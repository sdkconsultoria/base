<?php

namespace Sdkconsultoria\Base;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrationsMacro();
        $this->registerMigrations();
        $this->registerCustomFactory();
        $this->registerRoutesMacro();
        $this->registerRoutes();
        $this->registerCommands();
        // $this->enableQueryLogs();
        Route::mixin(new AuthRouteMethods);


        $this->loadViewsFrom(__DIR__.'/../views', 'base');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'base');

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
            __DIR__ . '/../config/base.php', 'base'
        );

        $this->app->bind('base',function(){
            return new Base();
        });
    }

    private function registerMigrationsMacro()
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
            $this->smallInteger('status')->default('20');
        });

        Blueprint::macro('translatable', function () {
            $table = str_replace('_translates', '', $this->table);
            $table = Str::plural($table);
            $this->unsignedBigInteger('translatable_id');
            $this->foreign('translatable_id')->references('id')->on($table);
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
                return Str::of($model_name)->replace('Models', 'Factories') . 'Factory';
            }

            $namespace = 'Database\\Factories\\';

            $model_name = str_replace('App\\Models\\', '', $model_name);

            return $namespace . $model_name . 'Factory';
        });
    }

    private function registerRoutesMacro()
    {
        Route::macro('SdkApiResource', function ($uri, $controller) {
            Route::get("{$uri}", "{$controller}@viewAny")->name("api.{$uri}.view-any");
            Route::get("{$uri}/{id}", "{$controller}@view")->name("api.{$uri}.view");
            Route::post("{$uri}", "{$controller}@storage")->name("api.{$uri}.create");
            Route::put("{$uri}/{id}", "{$controller}@update")->name("api.{$uri}.update");
            Route::delete("{$uri}/{id}", "{$controller}@delete")->name("api.{$uri}.delete");
        });
    }

    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    private function registerCommands() : void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sdkconsultoria\Base\Console\Commands\InstallCommand::class,
                \Sdkconsultoria\Base\Console\Commands\MakeCrud::class,
                \Sdkconsultoria\Base\Console\Commands\Permissions::class,
                \Sdkconsultoria\Base\Console\Commands\User::class,
            ]);
        }
    }

    private function enableQueryLogs()
    {
        \DB::listen(function($query) {
           \Log::info(
               $query->sql,
               $query->bindings,
               $query->time
           );
       });
    }
}
