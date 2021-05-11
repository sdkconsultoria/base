<?php

namespace Sdkconsultoria\Base;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::mixin(new AuthRouteMethods);

        $this->registerCommands();
        $this->registerMigrationsShortcut();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../views', 'base');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'base');
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/base'),
        ]);
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

        $this->app->bind('base',function(){
            return new Base();
        });
    }

    /**
     * Registra los comandos e SDK Base
     * @return void
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sdkconsultoria\Base\Console\Commands\InstallCommand::class,
            ]);
        }
    }

    /**
     * Registra los atajos para las migraciones
     * @return void
     */
    private function registerMigrationsShortcut()
    {
        Blueprint::macro('commonFields', function () {
            $this->id();
            $this->genericFields();
        });

        Blueprint::macro('genericFields', function () {
            $this->statusField();
            $this->timestampsFields();
            $this->creatingFields();
        });

        Blueprint::macro('creatingFields', function () {
            $this->foreignId('created_by')->nullable()->constrained('users');
            $this->foreignId('updated_by')->nullable()->constrained('users');
            $this->foreignId('deleted_by')->nullable()->constrained('users');
        });

        Blueprint::macro('timestampsFields', function () {
            $this->timestamps();
            $this->timestamp('deleted_at')->nullable();
        });

        Blueprint::macro('statusField', function () {
            $this->smallInteger('status')->default('15');
        });
    }
}
