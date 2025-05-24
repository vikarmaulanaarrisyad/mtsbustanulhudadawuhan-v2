<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Halaman;
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalKategori = Kategori::count();
        $totalBerita   = Berita::where('status', 'publish')->count();
        $totalMenu     = Menu::count();
        $totalHalaman  = Halaman::count();

        // cek user yang login
        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index', compact([
                'totalKategori',
                'totalBerita',
                'totalMenu',
                'totalHalaman',
            ]));
        } else {
            return view('operator.dashboard.index');
        }
    }
}
