<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Halaman;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $listBerita = Berita::with('kategori', 'user', 'komentars')->where('status', 'publish')->limit(10)->take(10)->orderBy('published_at', 'desc')->get();
        $sliders = Berita::where('status', 'publish')->where('is_slider', '1')->get();
        return view('frontend.homepage.index', compact('listBerita', 'sliders'));
    }

    public function detail($slug)
    {
        // 0. Jika slug adalah 'berita', tampilkan semua berita
        if ($slug === 'berita') {
            $listBerita = Berita::where('status', 'publish')->latest()->paginate(12); // bisa juga pakai ->get() jika tidak perlu pagination
            return view('frontend.berita.index', compact('listBerita'));
        }

        // 1. Coba cari slug di tabel berita dulu
        $berita = Berita::where('slug', $slug)->first();

        if ($berita) {
            $recentPosts = Berita::where('slug', '!=', $slug)
                ->latest()
                ->take(5)
                ->get();

            return view('frontend.berita.detail', compact('berita', 'recentPosts'));
        }

        // 2. Jika bukan berita, coba cari sebagai halaman
        $menu = Menu::where('menu_url', $slug)->first();

        if ($menu) {
            $halaman = Halaman::where('menu_id', $menu->id)->first();

            if ($halaman) {
                return view('frontend.homepage.halaman.index', compact('halaman'));
            }
        }

        // 3. Jika tidak ditemukan di dua-duanya, tampilkan 404
        return view('not-found');
    }
}
