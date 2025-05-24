<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/manifest.json', function () {
    $env = env('APP_ENV_TYPE', 'production');

    // Tentukan warna berdasarkan environment
    $backgroundColor = $env === 'staging' ? '#ffeb3b' : '#6777ef';  // Contoh warna untuk staging (kuning) dan production (biru)
    $themeColor = $env === 'staging' ? '#ffeb3b' : '#6777ef';

    return response()->json([
        'name' => $env === 'staging' ? 'SIAKAD Staging' : 'SIAKAD Apps',
        'short_name' => env('APP_SHORT_NAME', 'SIAKAD'),
        'start_url' => '/index.php',
        'background_color' => $backgroundColor,
        'description' => env('APP_DESCRIPTION'),
        'display' => 'fullscreen',
        'theme_color' => $themeColor,
        'env_type' => $env,
        'icons' => [
            [
                'src' => asset('logo.png'),
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ]
        ],
    ])->header('Content-Type', 'application/manifest+json');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role Admin
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
        // Manage Menu
        Route::post('/manage-menu/update-order', [MenuController::class, 'updateOrder'])->name('manage-menu.updateOrder');
        Route::get('/manage-menu/getAll-menu', [MenuController::class, 'getAllMenu'])->name('getAll.menu');
        Route::get('/manage-menu/get-submenu', [MenuController::class, 'getAllSubmenu'])->name('getAll.submenu');
        Route::resource('/manage-menu', MenuController::class);

        //Kategori
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::get('/kategori/get-all', [KategoriController::class, 'getAll'])->name('kategori.getAll');
        Route::resource('/kategori', KategoriController::class);

        // Berita
        Route::get('/berita/data', [BeritaController::class, 'data'])->name('berita.data');
        Route::resource('/berita', BeritaController::class);
        Route::post('/berita/{id}/slider-update', [BeritaController::class, 'updateSlider'])->name('berita.slider.update');
        Route::post('/berita/{id}/status-update', [BeritaController::class, 'updateStatus'])->name('berita.status.update');
        Route::put('/berita/kategori/update/{id}', [BeritaController::class, 'updateKategori'])->name('berita.kategori.update');
        Route::post('/berita/delete-selected', [BeritaController::class, 'deleteSelected'])->name('berita.deleteSelected');

        // Halaman Statis
        Route::get('/halaman/data', [HalamanController::class, 'data'])->name('halaman.data');
        Route::resource('/halaman', HalamanController::class);
        Route::post('/halaman/delete-selected', [HalamanController::class, 'deleteSelected'])->name('halaman.deleteSelected');

        // Pengaturan
        Route::get('/setting', [SettingController::class, 'data'])->name('setting.data');
        Route::resource('/setting', SettingController::class);
    });
});
Route::get('/', [HomePageController::class, 'index'])->name('homepage.index');
Route::get('/{slug}', [HomePageController::class, 'detail'])->name('homepage.detail');
