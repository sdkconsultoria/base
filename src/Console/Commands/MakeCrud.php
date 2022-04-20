<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
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
        $this->fixController($model);
        $this->generateRoute($model);

        $this->info("Se creó correctamente el CRUD {$model}.");
    }

    private function createModel(string $model)
    {
        Artisan::call("make:model {$model} -crmf --test");
        $this->comment('Modelo Creado.');
    }

    private function generateRoute(string $model)
    {
        $singular = Str::singular(Str::kebab($model));
        $route = '    Route::SdkResource(\'' . $singular . '\', ' . $model . 'Controller::class);';

        if( strpos(file_get_contents(base_path('routes/web.php')), $route) !== false) {
            return;
        }

        $this->replaceInFile(
            "->prefix('admin')->group(function () {",
            "->prefix('admin')->group(function () { \n" . $route,
            base_path('routes/web.php')
        );
    }

    private function fixController(string $model)
    {
        $controllers_path = app_path('Http/Controllers/Admin/');

        $this->ensureFolderExist($controllers_path);

        $controller = app_path('Http/Controllers/' . $model . 'Controller.php');
        $new_controller = app_path('Http/Controllers/Admin/' . $model . 'Controller.php');

        if (file_exists($new_controller)) {
            return;
        }

        $this->replaceInFile('App\Http\Controllers', 'App\Http\Controllers\Admin', $controller);

        rename($controller, $new_controller);
    }

    protected function ensureFolderExist(string $folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder);
        }
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
