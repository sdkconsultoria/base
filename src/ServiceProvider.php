<?php

namespace Sdkconsultoria\Base;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Sdkconsultoria\Base\Services\MenuService;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();
        $this->registerCustomFactory();
        $this->registerRoutes();
        $this->registerCommands();
        // $this->enableQueryLogs();
        Route::mixin(new AuthRouteMethods);

        $this->loadViewsFrom(__DIR__.'/../views', 'base');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'base');
        $this->registerMenu();

        // $this->publishes([
        //     __DIR__.'/../views' => resource_path('views/vendor/base'),
        // ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/base.php', 'base'
        );

        $this->app->singleton(MenuService::class, function () {
            return new MenuService();
        });

        $this->app->bind('base', function () {
            return new Base();
        });
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/common');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/blogs');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/ecommerce');
    }

    private function registerCustomFactory()
    {
        Factory::guessFactoryNamesUsing(function (string $model_name) {
            $sdk = Str::startsWith($model_name, 'Sdkconsultoria');

            if ($sdk) {
                return Str::of($model_name)->replace('Models', 'Factories').'Factory';
            }

            $namespace = 'Database\\Factories\\';

            $model_name = str_replace('App\\Models\\', '', $model_name);

            return $namespace.$model_name.'Factory';
        });
    }

    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sdkconsultoria\Base\Console\Commands\MakeCrud::class,
            ]);
        }
    }

    private function registerMenu()
    {
        $service_menu = app(MenuService::class);
        $service_menu->addElement([
            'name' => 'Dashboard',
            'icon' => \Base::icon('home', ['class' => 'h-6 w-6']),
            'url' => 'dashboard',
        ]);
        $service_menu->addElement(\App\Models\User::makeMenu('users'));
    }

    private function enableQueryLogs()
    {
        \DB::listen(function ($query) {
            \Log::info(
               $query->sql,
               $query->bindings,
               $query->time
           );
        });
    }
}
