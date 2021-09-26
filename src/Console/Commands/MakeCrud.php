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
        $stub = str_replace('$model', strtolower($model), $stub);

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
            resource_path('views/' . strtolower($model)));
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
            '$view = \'' . strtolower($model). '.\'',
            app_path('Http/Controllers/' . $model . 'Controller.php'));
    }

    /**
     * Escribe la ruta del recurso.
     * @param  string $model
     * @return void
     */
    private function generateRoute(string $model)
    {
        $plural = Str::plural(strtolower($model));
        $route = 'Route::resource(\'/admin/' . $plural .'\' , \App\Http\Controllers\\' . $model . 'Controller::class);';
        file_put_contents(base_path('routes/web.php'), $route, FILE_APPEND);
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
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
