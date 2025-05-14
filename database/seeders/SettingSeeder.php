<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting; // pastikan path-nya sesuai

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'nama_aplikasi' => 'SIAKAD',
            'singkatan' => 'SIAKAD',
            'copyright' => 'Vikar Maulana'
        ];

        Setting::firstOrCreate(['nama_aplikasi' => $data['nama_aplikasi']], $data);
    }
}
