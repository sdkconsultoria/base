<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:user {email=admin@sdkconsultoria.com} {name=default} {lastname=default} {role=super-admin} {--token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un usuario y/o obtiene el token';

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
        $user = $this->createUser();
        $this->asingRolesToUser($user);

        $token = $this->option('token');
        if ($token) {
            $this->info("token: " . $user->createToken('token')->plainTextToken);
        }

        return 0;
    }

    private function createUser()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');
        $lastname = $this->argument('lastname');

        $user = config('auth.providers.users.model')::where('email', $email)->first();

        if($user) {
            $this->info("El usuario $email ya existe");

            return $user;
        }

        $user = new (config('auth.providers.users.model'));
        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->password = 'password';
        $user->status = config('auth.providers.users.model')::STATUS_ACTIVE;
        $user->save();

        $this->info("Se creo el usuario $email");

        return $user;
    }

    private function asingRolesToUser($user)
    {
        $role = $this->argument('role');

        $user->assignRole([$role]);
    }
}
