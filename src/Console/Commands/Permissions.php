<?php

namespace Sdkconsultoria\Base\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea los roles y permisos';

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
        $this->createRoles();
        $this->createPermissions();

        return Command::SUCCESS;
    }

    private function createRoles()
    {
        $roles = array_merge($this->roles(), $this->defaultRoles());

        foreach ($roles as $rol) {
            $this->findRoleOrCreate($rol);
        }
    }

    private function createPermissions()
    {
        $models = array_merge($this->models(), $this->defaultModels());
        $permisions = array_merge($this->permissions(), $this->defaultPermissions());

        foreach ($models as $model) {
            foreach ($permisions as $permision) {
                $this->findPermissionOrCreate($model, $permision);
            }
        }
    }

    protected function roles() : array
    {
        return [];
    }

    protected function permissions() : array
    {
        return [];
    }

    protected function models() : array
    {
        return [];
    }

    private function defaultRoles() : array
    {
        return ['super-admin', 'admin', 'user'];
    }

    private function defaultPermissions() : array
    {
        return ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];
    }

    private function defaultModels() : array
    {
        return [
            'user',
            'blog',
            'blog_post',
        ];
    }

    private function findRoleOrCreate(string $role) : Role
    {
        return Role::firstOrCreate(['name' => $role]);
    }

    private function findPermissionOrCreate(string $model, string $permision) : Permission
    {
        return Permission::firstOrCreate(['name' => "{$model}:{$permision}"]);
    }
}
