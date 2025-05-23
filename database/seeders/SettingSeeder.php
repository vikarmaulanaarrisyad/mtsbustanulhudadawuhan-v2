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
            'nama_madrasah' => 'MTs Bustanul Huda Dawuhan',
            'nama_yayasan' => 'Bustanul Huda Dawuhan',
            'singkatan' => 'SIAKAD',
            'tentang' => 'SIAKAD',
            'copyright' => 'Vikar Maulana',
            'nomorwa' => '08785344234'
        ];

        Setting::firstOrCreate(['nama_aplikasi' => $data['nama_aplikasi']], $data);
    }
}
