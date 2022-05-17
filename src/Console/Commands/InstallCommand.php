<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala la libreria SDK';

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
        Artisan::call("sdk:core-install");

        $this->copyStubs();
        $this->updateNode();
        $this->writteResources();
        $this->writteTailwindConfig();
        $this->writteUserChanges();
        $this->writteConfig();


        $this->info('SDK Base se instalo correctamente.');
        $this->comment('Ejecuta el comando "npm install && npm run sdk && npm run dev" para generar tus assets.');
    }

    /**
     * Copia los stubs
     * @return void
     */
    private function copyStubs()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('stubs'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/stubs', base_path('stubs'));


        copy(__DIR__.'/../../../stubs/routes/web.php', base_path('routes/web.php'));
        // copy(__DIR__.'/../../../stubs/.gitignore', base_path('.gitignore'));
        // copy(__DIR__.'/../../../stubs/.env.example', base_path('.env.example'));
        // copy(__DIR__.'/../../../stubs/phpunit.xml', base_path('phpunit.xml'));


        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/public/img', base_path('public/img'));

    }

    private function writteResources()
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views', base_path('resources/views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/lang', base_path('resources/lang'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/back', base_path('resources/back'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/front', base_path('resources/front'));
    }

    private function writteUserChanges()
    {
        copy(__DIR__.'/../../../stubs/models/User.php', base_path('app/Models/User.php'));
    }

    private function writteTailwindConfig()
    {
        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
    }

    private function writteConfig()
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/app/', base_path('app'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/config/', base_path('config'));
    }

    private function updateNode()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                'autoprefixer' =>  '^10.4.0',
                'axios' => '^0.27.2',
                'postcss' =>  '^8.4.13',
                'tailwindcss' =>  '^3.0.7',
                'postcss-import' => '^14.0.2',
                '@tailwindcss/forms' => '^0.4.0',
                'alpinejs' => '^3.7.1',
                'sweetalert2' => '^11.4.4',
                'jodit' => '^3.14.3',
                'cropperjs' => '^1.5.12',
                'photoswipe' => '^4.1.3',
                'vue' => '^3.2.26',
                'vue-loader' => '^17.0.0',
                '@sdkconsultoria/base' => 'file:vendor/sdkconsultoria/base',
                '@heroicons/vue' => '^1.0.6',
            ] + $packages;
        });

        // NPM scripts
        $this->updateNodeScripts(function ($scripts) {
            return [
                'sdk' => 'cd vendor/sdkconsultoria/base && npm install',
            ] + $scripts;
        });
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
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @return void
     */
    protected static function updateNodeScripts(callable $callback)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = 'scripts';

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
