<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DOMDocument;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.berita.index');
    }

    public function data()
    {
        $query = Berita::orderBy('id', 'desc')->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('selectAll', function ($q) {
                return '
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input row-checkbox" name="selected[]" value="' . $q->id . '" data-id="' . $q->id . '">
                    </div>
                ';
            })

            ->addColumn('kategori', function ($q) {
                return '';
            })
            ->addColumn('aksi', function ($q) {
                return '
                <button class="btn btn-sm" style="background-color:#ff7f27; color:#fff;" title="Edit">
                    <i class="fa fa-pencil-alt"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#d81b60; color:#fff;" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#6755a5; color:#fff;" title="Folder">
                    <i class="fa fa-folder"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#cde3f3; color:#000;" title="Chat">
                    <i class="fa fa-comment"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#011c3d; color:#fff;" title="Unlock">
                    <i class="fa fa-unlock"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#36bec9; color:#fff;" title="Star">
                    <i class="fa fa-star"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#9e9ea0; color:#fff;" title="Play">
                    <i class="fa fa-play"></i>
                </button>
                <button class="btn btn-sm" style="background-color:#2b9f4e; color:#fff;" title="View">
                    <i class="fa fa-eye"></i>
                </button>
            ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'isi'          => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file'         => 'nullable|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'nama_file'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        // Proses gambar base64 di konten `isi`
        $isi = $request->isi;
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            // Cek jika gambar adalah base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $extension = strtolower($type[1]);

                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    continue;
                }

                $filename = Str::random(20) . '.' . $extension;
                $path = 'images/' . $filename;
                Storage::disk('public')->put($path, $data);

                $img->setAttribute('src', asset('storage/' . $path));
            }
        }

        // Simpan kembali isi yang sudah diproses
        $isiFinal = $dom->saveHTML();

        $data = [
            'user_id' => Auth::user()->id,
            'kategori_id' => 1,
            'judul'     => $request->judul,
            'ringkasan'     => $request->judul,
            'isi'       => $isiFinal,
            'slug'      => Str::slug($request->judul),
            'thumbnail' => $request->hasFile('thumbnail') ? upload('berita', $request->thumbnail, 'thumbnail') : null,
            'file'      => $request->hasFile('file') ? upload('file', $request->file, $request->nama_file) : null,
            'published_at' => $request->published_at,
            'nama_file' => $request->nama_file,
        ];

        Berita::create($data);

        return response()->json([
            'message' => 'Berita berhasil simpan',
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        //
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Tidak ada data yang dipilih.'], 422);
        }

        try {
            $beritas = Berita::whereIn('id', $ids)->get();

            foreach ($beritas as $berita) {
                // Hapus gambar-gambar yang ada di konten 'isi'
                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($berita->isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors();

                foreach ($dom->getElementsByTagName('img') as $img) {
                    $src = $img->getAttribute('src');
                    $prefix = asset('storage') . '/';

                    if (strpos($src, $prefix) === 0) {
                        $relativePath = str_replace($prefix, '', $src);
                        $fullPath = public_path('storage/' . $relativePath);
                        if (file_exists($fullPath)) {
                            @unlink($fullPath);
                        }
                    }
                }

                if (!empty($berita->thumbnail)) {
                    if (Storage::disk('public')->exists($berita->thumbnail)) {
                        Storage::disk('public')->delete($berita->thumbnail);
                    }
                }

                if (!empty($berita->file)) {
                    if (Storage::disk('public')->exists($berita->file)) {
                        Storage::disk('public')->delete($berita->file);
                    }
                }
            }

            // Setelah semua file dihapus, hapus data dari database
            Berita::whereIn('id', $ids)->delete();

            return response()->json(['message' => count($ids) . ' data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
