<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Halaman;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HalamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.halaman.index');
    }

    public function data()
    {
        $query = Halaman::with('menu')
            ->orderBy('id', 'desc')
            ->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('selectAll', function ($q) {
                return '
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input row-checkbox" name="selected[]" value="' . $q->id . '" data-id="' . $q->id . '">
                    </div>
                ';
            })
            ->editColumn('menu', function ($q) {
                return $q->menu->menu_title ?? '-';
            })
            ->addColumn('status', function ($q) {
                switch ($q->status) {
                    case 'publish':
                        return '<span class="badge bg-success">Publish</span>';
                    case 'archived':
                        return '<span class="badge bg-danger">Archived</span>';
                    case 'draft':
                    default:
                        return '<span class="badge bg-warning text-dark">Draft</span>';
                }
            })
            ->editColumn('aksi', function ($q) {
                return '
                <a href="' . route('halaman.edit', $q->id) . '" class="btn btn-sm" style="background-color:#ff7f27; color:#fff;" title="Edit">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <button onclick="deleteData(`' . route('halaman.destroy', $q->id) . '`,`' . $q->judul . '`)" class="btn btn-sm" style="background-color:#d81b60; color:#fff;" title="Delete">
                    <i class="fa fa-trash"></i>
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
        return view('admin.halaman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'isi'          => 'required|string',
            'menu_parent_id' => 'required',
            'status'       => 'required',
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
        // Cek apakah menu_parent_id sudah digunakan
        $existingHalaman = Halaman::where('menu_id', $request->menu_parent_id)->first();

        if ($existingHalaman) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sub Menu ini sudah digunakan di halaman lain.',
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
                $path = 'images/halaman/' . $filename;
                Storage::disk('public')->put($path, $data);

                $img->setAttribute('src', asset('storage/' . $path));
            }
        }

        // Simpan kembali isi yang sudah diproses
        $isiFinal = $dom->saveHTML();

        $data = [
            'menu_id'  => $request->menu_parent_id,
            'judul'     => $request->judul,
            'status'     => $request->status,
            'isi'       => $isiFinal,
            'slug'      => Str::slug($request->judul),
            'file'      => $request->hasFile('file') ? upload('file', $request->file, $request->nama_file) : null,
            'published_at' => Carbon::now(),
            'nama_file' => $request->nama_file,
        ];

        Halaman::create($data);

        return response()->json([
            'message' => 'Halaman berhasil simpan',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Halaman $halaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $halaman = Halaman::findOrfail($id);

        return view('admin.halaman.edit', compact('halaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $query = Halaman::findOrfail($id);

        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'isi'          => 'required|string',
            'status'       => 'required',
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

        // Ambil isi lama dari database dan ekstrak gambar
        $isiLama = $query->isi;
        $gambarLama = [];

        if ($isiLama) {
            $domLama = new DOMDocument();
            libxml_use_internal_errors(true);
            $domLama->loadHTML($isiLama, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            $gambarLamaTags = $domLama->getElementsByTagName('img');
            foreach ($gambarLamaTags as $img) {
                $src = $img->getAttribute('src');
                if (strpos($src, '/storage/') !== false) {
                    $path = explode('/storage/', $src)[1];
                    $gambarLama[] = $path;
                }
            }
        }

        // Proses isi baru
        $isiBaru = $request->isi;
        $gambarBaru = [];

        $domBaru = new DOMDocument();
        libxml_use_internal_errors(true);
        $domBaru->loadHTML($isiBaru, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $domBaru->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            // Jika src adalah gambar lama
            if (strpos($src, '/storage/') !== false) {
                $path = explode('/storage/', $src)[1];
                $gambarBaru[] = $path;
                continue;
            }

            // Jika src adalah base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $extension = strtolower($type[1]);

                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    continue;
                }

                $filename = Str::random(20) . '.' . $extension;
                $path = 'images/halaman/' . $filename;
                Storage::disk('public')->put($path, $data);

                $img->setAttribute('src', asset('storage/' . $path));
                $gambarBaru[] = $path;
            }
        }

        // Hapus gambar lama yang tidak digunakan lagi
        $gambarYangDihapus = array_diff($gambarLama, $gambarBaru);
        foreach ($gambarYangDihapus as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        // Simpan kembali isi yang sudah diproses
        $isiFinal = $domBaru->saveHTML();

        // Hapus file lampiran lama jika ada file baru
        if ($request->hasFile('file') && $query->file && Storage::disk('public')->exists($query->file)) {
            Storage::disk('public')->delete($query->file);
        }

        // Inisialisasi nilai default
        $file = $query->file;
        $nama_file = $query->nama_file;

        // Jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($query->file && Storage::disk('public')->exists($query->file)) {
                Storage::disk('public')->delete($query->file);
            }

            // Upload file baru dengan nama dari request
            $file = upload('file', $request->file, $request->nama_file);
            $nama_file = $request->nama_file;
        }

        $data = [
            'judul'     => $request->judul,
            'status'     => $request->status,
            'isi'       => $isiFinal,
            'slug'      => Str::slug($request->judul),
            'file'          => $file,
            'published_at' => Carbon::now(),
            'nama_file'     => $nama_file,
            'status'        => $request->status,
        ];

        $query->update($data);

        return response()->json([
            'message' => 'Halaman berhasil simpan',
        ], 200);
    }

    public function destroy($id)
    {
        $query = Halaman::findOrFail($id);

        // Hapus file lampiran jika ada
        if (!empty($query->file)) {
            if (Storage::disk('public')->exists($query->file)) {
                Storage::disk('public')->delete($query->file);
            }
        }

        // Hapus gambar di dalam konten Summernote
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($query->isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');
            $prefix = asset('storage/images/halaman') . '/';

            // Jika gambar dari folder images/halaman
            if (strpos($src, $prefix) === 0) {
                $relativePath = str_replace(asset('storage') . '/', '', $src); // images/halaman/namafile.jpg
                $fullPath = public_path('storage/' . $relativePath); // path lengkap ke file
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }

        // Hapus data dari database
        $query->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Tidak ada data yang dipilih.'], 422);
        }

        try {
            $halamans = Halaman::whereIn('id', $ids)->get();

            foreach ($halamans as $halaman) {
                // Hapus gambar-gambar yang ada di konten 'isi'
                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($halaman->isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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

                if (!empty($halaman->thumbnail)) {
                    if (Storage::disk('public')->exists($halaman->thumbnail)) {
                        Storage::disk('public')->delete($halaman->thumbnail);
                    }
                }

                if (!empty($halaman->file)) {
                    if (Storage::disk('public')->exists($halaman->file)) {
                        Storage::disk('public')->delete($halaman->file);
                    }
                }
            }

            // Setelah semua file dihapus, hapus data dari database
            Halaman::whereIn('id', $ids)->delete();

            return response()->json(['message' => count($ids) . ' data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
