<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function data()
    {
        $query = Kategori::orderBy('id', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('selectAll', function ($q) {
                return '
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input row-checkbox" name="selected[]" value="' . $q->id . '" data-id="' . $q->id . '">
                    </div>
                ';
            })
            ->addColumn('aksi', function ($q) {
                return '
                <button onclick="editForm(`' . route('kategori.show', $q->id) . '`)" class="btn btn-sm" style="background-color:#ff7f27; color:#fff;" title="Edit">
                    <i class="fa fa-pencil-alt"></i>
                </button>
                <button onclick="deleteData(`' . route('kategori.destroy', $q->id) . '`,`' . $q->nama . '`)" class="btn btn-sm" style="background-color:#d81b60; color:#fff;" title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function getAll(Request $request)
    {
        $search = $request->get('q', '');

        // Query kategori, filter jika ada pencarian
        $query = Kategori::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Eksekusi query dan ambil data
        $categories = $query->select('id', 'nama')->get();

        return response()->json([
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi ?? '-',
            'slug' => Str::slug($request->nama),
        ];

        Kategori::create($data);

        return response()->json(['message' => 'Kategori berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return response()->json(['data' => $kategori]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $slugBaru = Str::slug($request->nama);

        // Cek apakah slug baru sudah digunakan oleh kategori lain
        $slugSudahAda = Kategori::where('slug', $slugBaru)
            ->where('id', '!=', $kategori->id)
            ->exists();

        if ($slugSudahAda) {
            return response()->json([
                'status' => 'error',
                'errors' => ['slug' => ['Slug sudah digunakan, silakan gunakan nama lain.']],
                'message' => 'Slug sudah ada di kategori lain.',
            ], 422);
        }

        // Update data
        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi ?? '-',
            'slug' => $slugBaru,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kategori berhasil diperbarui.',
            'data' => $kategori
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrfail($id);
        $kategori->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    /**
     * Remove all
     */
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'Tidak ada data yang dipilih.'], 422);
        }

        try {
            Kategori::whereIn('id', $ids)->delete();

            return response()->json(['message' => count($ids) . ' data berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
