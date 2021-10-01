<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un crud SDK';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');
        $this->createModel($model);
        $this->copyViews($model);
        $this->generateRoute($model);
        $this->writteViewController($model);
        $this->fixController($model);
        $this->writeTranslations($model);

        $this->info("Se creó correctamente el CRUD {$model}.");
        $this->comment('Migraciones creadas.');
        $this->comment('Modelo Creado.');
        $this->comment('vistas creadas.');
        $this->comment('controlador creado.');
        $this->comment('traducciones creadas.');
    }

    /**
     * Ejecuta el comando de modelos.
     * @param  string $model
     * @return void
     */
    private function createModel(string $model)
    {
        Artisan::call("make:model {$model} -crmf");
    }

    /**
     * Escribe las traducciones comunes para un modelo
     * @param  string $model
     * @return void
     */
    private function writeTranslations(string $model)
    {
        $stub = file_get_contents(__DIR__.'/../../../stubs/c_stubs/lang/models.php');
        $stub = str_replace('$model', Str::kebab($model), $stub);

        $this->replaceInFile(
            '];', $stub, resource_path('lang/es/models.php'));
    }

    /**
     * Copia las views por defecto
     * @return void
     */
    private function copyViews(string $model)
    {
        (new Filesystem)->copyDirectory(
            __DIR__.'/../../../stubs/views/',
            resource_path('views/admin/' . Str::kebab($model)));
    }

    /**
     * Corrigue el namespace del controllador
     * @param  string $model
     * @return void
     */
    private function fixController(string $model)
    {
        $controller_path = app_path('Http/Controllers/' . $model . 'Controller.php');
        $this->replaceInFile('App\Http\Controllers', 'App\Http\Controllers\Admin', $controller_path);

        rename(
            $controller_path,
            app_path('Http/Controllers/Admin/' . $model . 'Controller.php'));
    }

    /**
     * Asigna las vistas al controlador
     * @param  string $model
     * @return void
     */
    private function writteViewController($model)
    {
        $this->replaceInFile(
            '$view = \'\'',
            '$view = \'admin.' . Str::kebab($model) . '.\'',
            app_path('Http/Controllers/' . $model . 'Controller.php'));
    }

    /**
     * Escribe la ruta del recurso.
     * @param  string $model
     * @return void
     */
    private function generateRoute(string $model)
    {
        $plural = Str::plural(Str::kebab($model) );
        $route = '    Route::resource(\'' . $plural .'\', ' . $model . 'Controller::class);';
        $this->replaceInFile(
            "->prefix('admin')->group(function () {",
            "->prefix('admin')->group(function () { \n" . $route, base_path('routes/web.php'));
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
