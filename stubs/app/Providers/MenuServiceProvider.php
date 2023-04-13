<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sdkconsultoria\Base\Services\MenuService;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $service_menu = app(MenuService::class);
        $service_menu->addElement(\App\Models\User::makeMenu('users'));
        $service_menu->addElement([
            'name' => 'Dashboard',
            'icon' => \Base::icon('home', ['class' => 'h-6 w-6']),
            'url' => 'dashboard',
        ]);
    }
}
