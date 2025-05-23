<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $rules = [
            'nama_madrasah' => 'required',
            'nama_yayasan' => 'required',
            'nomorwa' => 'required|string|min:11|max:17',
            'tentang' => 'required',
            'deskripsi' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $data = $request->except('favicon', 'logo_login', 'logo', 'background');

        if ($request->hasFile('logo') && $setting->logo) {
            if (Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $data['logo'] = upload('setting', $request->file('logo'), 'setting');
        }

        if ($request->hasFile('favicon') && $setting->favicon) {
            if (Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }

            $data['favicon'] = upload('setting', $request->file('favicon'), 'setting');
        }

        if ($request->hasFile('logo_login') && $setting->logo_login) {
            if (Storage::disk('public')->exists($setting->logo_login)) {
                Storage::disk('public')->delete($setting->logo_login);
            }

            $data['logo_login'] = upload('setting', $request->file('logo_login'), 'setting');
        }

        if ($request->hasFile('background_image') && $setting->background_image) {
            if (Storage::disk('public')->exists($setting->background_image)) {
                Storage::disk('public')->delete($setting->background_image);
            }

            $data['background_image'] = upload('setting', $request->file('background_image'), 'setting');
        }

        $setting->update($data);

        return back()->with([
            'message' => 'Pengaturan berhasil diperbarui',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
