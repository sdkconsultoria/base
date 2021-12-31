<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;

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
        $this->copyStubs();

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                'autoprefixer' =>  '^10.4.0',
                'postcss' =>  '^8.4.5',
                'tailwindcss' =>  '^3.0.7',
                'postcss-import' => '^12.0.1',
                '@tailwindcss/forms' => '^0.4.0',
                'alpinejs' => '^3.7.1',
                'sweetalert2' => '^11.3.0',
                'jodit' => '^3.11.3',
                'cropperjs' => '^1.5.12',
                'photoswipe' => '^4.1.3',
                'vue' => '^3.2.26',
                'vue-loader' => '^17.0.0',
                '@sdkconsultoria/base' => 'file:vendor/sdkconsultoria/base',
            ] + $packages;
        });

        $this->info('SDK Base se instalo correctamente.');
        $this->comment('Ejecuta el comando "npm install && npm run sdk && npm run dev" para generar tus assets.');
    }

    /**
     * Copia los stubs
     * @return void
     */
    private function copyStubs()
    {
        // if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
        //     continue;
        // }
        (new Filesystem)->ensureDirectoryExists(app_path('stubs'));
        copy(__DIR__.'/../../../stubs/models/User.php', base_path('app/Models/User.php'));
        copy(__DIR__.'/../../../stubs/seeders/UserSeeder.php', base_path('database/seeders/UserSeeder.php'));
        copy(__DIR__.'/../../../stubs/factories/UserFactory.php', base_path('database/factories/UserFactory.php'));
        copy(__DIR__.'/../../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../../stubs/app/Http/Kernel.php', base_path('app/Http/Kernel.php'));
        copy(__DIR__.'/../../../stubs/.gitignore', base_path('.gitignore'));
        copy(__DIR__.'/../../../stubs/.env.example', base_path('.env.example'));
        copy(__DIR__.'/../../../stubs/phpunit.xml', base_path('phpunit.xml'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/stubs', base_path('stubs'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/views', base_path('resources/views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/lang', base_path('resources/lang'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/back', base_path('resources/back'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/resources/front', base_path('resources/front'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/public/images', base_path('public/images'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/app/', base_path('app'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/config/', base_path('config'));
        // $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
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
