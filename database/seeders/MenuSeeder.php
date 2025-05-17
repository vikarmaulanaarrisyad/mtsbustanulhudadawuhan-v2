<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->truncate(); // bersihkan dulu isi tabel menus

        // Menu Utama
        $home = DB::table('menus')->insertGetId([
            'menu_title' => 'Home',
            'menu_url' => 'index.html',
            'menu_target' => '_self',
            'menu_type' => 'link',
            'menu_parent_id' => 0,
            'menu_position' => 1,
        ]);

        $profil = DB::table('menus')->insertGetId([
            'menu_title' => 'Profil',
            'menu_url' => '#',
            'menu_target' => '_self',
            'menu_type' => 'dropdown',
            'menu_parent_id' => 0,
            'menu_position' => 2,
        ]);

        $program = DB::table('menus')->insertGetId([
            'menu_title' => 'Program',
            'menu_url' => '#',
            'menu_target' => '_self',
            'menu_type' => 'dropdown',
            'menu_parent_id' => 0,
            'menu_position' => 3,
        ]);

        $informasi = DB::table('menus')->insertGetId([
            'menu_title' => 'Informasi',
            'menu_url' => '#',
            'menu_target' => '_self',
            'menu_type' => 'dropdown',
            'menu_parent_id' => 0,
            'menu_position' => 4,
        ]);

        // Submenu Profil
        DB::table('menus')->insert([
            [
                'menu_title' => 'Visi Misi',
                'menu_url' => 'about.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $profil,
                'menu_position' => 1,
            ],
            [
                'menu_title' => 'Profil Madrasah',
                'menu_url' => 'admissions.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $profil,
                'menu_position' => 2,
            ],
            [
                'menu_title' => 'Sambutan',
                'menu_url' => 'academics.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $profil,
                'menu_position' => 3,
            ],
            [
                'menu_title' => 'Tenaga Pendidik',
                'menu_url' => 'academics.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $profil,
                'menu_position' => 4,
            ],
        ]);

        // Submenu Program
        DB::table('menus')->insert([
            [
                'menu_title' => 'Ekstrakurikuler',
                'menu_url' => 'news-details.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $program,
                'menu_position' => 1,
            ],
            [
                'menu_title' => 'Program Madrasah',
                'menu_url' => 'event-details.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $program,
                'menu_position' => 2,
            ],
        ]);

        // Submenu Informasi
        DB::table('menus')->insert([
            [
                'menu_title' => 'Agenda',
                'menu_url' => 'news-details.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $informasi,
                'menu_position' => 1,
            ],
            [
                'menu_title' => 'Pengumuman',
                'menu_url' => 'event-details.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => $informasi,
                'menu_position' => 2,
            ],
        ]);

        // Menu Lainnya
        DB::table('menus')->insert([
            [
                'menu_title' => 'Berita',
                'menu_url' => 'students-life.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 5,
            ],
            [
                'menu_title' => 'Fasilitas',
                'menu_url' => 'news.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 6,
            ],
            [
                'menu_title' => 'Prestasi',
                'menu_url' => 'events.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 7,
            ],
            [
                'menu_title' => 'Layanan',
                'menu_url' => 'alumni.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 8,
            ],
            [
                'menu_title' => 'FAQ',
                'menu_url' => 'alumni.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 9,
            ],
            [
                'menu_title' => 'PPDB',
                'menu_url' => 'contact.html',
                'menu_target' => '_self',
                'menu_type' => 'link',
                'menu_parent_id' => 0,
                'menu_position' => 10,
            ],
        ]);
    }
}
