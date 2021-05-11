<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);

        $user = config('auth.providers.users.model')::create([
            'name' => 'admin',
            'lastname' => 'sdk',
            'slug' => 'admin',
            'email' => 'admin@sdkconsultoria.com',
            'password' => Hash::make('password'),
            'status' => 30,
        ]);

        $user->assignRole(['super-admin', 'admin']);
    }
}
