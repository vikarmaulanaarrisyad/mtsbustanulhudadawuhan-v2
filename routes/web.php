<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('homepage.index');

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
        //Kategori
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);

        // Berita
        Route::get('/berita/data', [BeritaController::class, 'data'])->name('berita.data');
        Route::resource('/berita', BeritaController::class);
        Route::post('/berita/delete-selected', [BeritaController::class, 'deleteSelected'])->name('berita.deleteSelected');


        // Manage Menu
        Route::post('/manage-menu/update-order', [MenuController::class, 'updateOrder'])->name('manage-menu.updateOrder');
        Route::resource('manage-menu', MenuController::class);
        Route::get('/get-submenu/{menu_id}', [MenuController::class, 'getSubmenu']);
    });
});
