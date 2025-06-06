<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.event.index');
    }

    public function data()
    {
        $query = Event::orderBy('id', 'desc')->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('tanggal_mulai', function ($q) {
                // $waktu =
                return tanggal_indonesia($q->tanggal_mulai, true, true);
            })
            ->editColumn('tanggal_selesai', function ($q) {
                // $waktu =
                return tanggal_indonesia($q->tanggal_selesai, true, true);
            })
            ->addColumn('selectAll', function ($q) {
                return '
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input row-checkbox" name="selected[]" value="' . $q->id . '" data-id="' . $q->id . '">
                    </div>
                ';
            })
            ->addColumn('aksi', function ($q) {
                return '
                <a href="' . route('event.edit', $q->id) . '" class="btn btn-sm" style="background-color:#ff7f27; color:#fff;" title="Edit">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <button onclick="deleteData(`' . route('event.destroy', $q->id) . '`,`' . $q->judul . '`)" class="btn btn-sm" style="background-color:#d81b60; color:#fff;" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
                <a target="_blank" href="' . route('homepage.detail', $q->slug) . '" class="btn btn-sm" style="background-color:#2b9f4e; color:#fff;" title="Lihat">
                <i class="fa fa-eye"></i>
                </a>
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
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek validasi awal
        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255|unique:beritas,judul',
            'isi'          => 'required|string',
            'lokasi'          => 'required|string',
            'thumbnail'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
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

        // Buat slug dari judul
        $slug = Str::slug($request->judul);

        // Cek apakah slug sudah digunakan
        if (Event::where('slug', $slug)->exists()) {
            return response()->json([
                'status' => 'error',
                'errors' => ['judul' => ['Slug dari judul sudah digunakan, silakan gunakan judul lain.']],
                'message' => 'Judul sudah digunakan.',
            ], 422);
        }

        // Proses isi yang mengandung gambar base64
        $isi = $request->isi;
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = base64_decode(substr($src, strpos($src, ',') + 1));
                $extension = strtolower($type[1]);
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) continue;

                $filename = Str::random(20) . '.' . $extension;
                $path = 'images/event/' . $filename;
                Storage::disk('public')->put($path, $data);
                $img->setAttribute('src', asset('storage/' . $path));
            }
        }

        $isiFinal = $dom->saveHTML();

        $data = [
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'lokasi' => $request->lokasi,
            'deskripsi' => $isiFinal,
            'slug' => $slug,
            'gambar' => $request->hasFile('thumbnail') ? upload('event', $request->thumbnail, 'thumbnail') : null,
            'file' => $request->hasFile('file') ? upload('file', $request->file, $request->nama_file) : null,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'nama_file' => $request->nama_file,
        ];
        Event::create($data);

        return response()->json([
            'message' => 'Event berhasil disimpan',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
