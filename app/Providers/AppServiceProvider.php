<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('setting', Setting::first());
            $menus = Menu::orderBy('menu_position')->get();

            $menuParents = $menus->where('menu_parent_id', 0);
            $menuChildren = $menus->where('menu_parent_id', '!=', 0);

            $view->with('menuParents', $menuParents)->with('menuChildren', $menuChildren);
        });
    }
}
