<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Berita Sekolah',
            'Pengumuman',
            'Agenda Kegiatan',
            'Kegiatan Siswa',
            'Prestasi',
            'Informasi PPDB',
            'Kurikulum',
        ];

        foreach ($kategori as $nama) {
            DB::table('kategoris')->insert([
                'nama' => $nama,
                'slug' => Str::slug($nama),
                'deskripsi' => Str::slug($nama),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
