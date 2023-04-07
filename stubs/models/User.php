<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Sdkconsultoria\Base\Fields\TextField;
use Sdkconsultoria\Core\Fields\PasswordField;
use Sdkconsultoria\Base\Models\Auth\UserSocial;
use Sdkconsultoria\Core\Models\Traits\BaseModel as TraitBaseModel;
use Sdkconsultoria\Core\Models\Traits\ImageTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use ImageTrait;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use TraitBaseModel;

    public const DEFAULT_SEARCH = 'like';

    public const STATUS_DELETED = 0;

    public const STATUS_BLOCKED = 10;

    public const STATUS_DISABLED = 15;

    public const STATUS_CREATION = 20;

    public const STATUS_ACTIVE = 30;

    public $canCreateEmpty = false;

    protected function fields()
    {
        return[
            TextField::make('name')
                ->label('Nombre')
                ->rules(['required'])
                ->filter([
                    'column' => [
                        'name',
                        'lastname',
                        'lastname_2',
                    ],
                ]),
            TextField::make('lastname')
                ->label('Apellido Paterno')
                ->rules(['required']),
            TextField::make('lastname_2')
                ->label('Apellido Materno')
                ->rules(['required']),
            TextField::make('email')
                ->label('Correo')
                ->rules(['required', 'email']),
            PasswordField::make('password')
                ->label('Contraseña')
                ->rules(['required', 'min:6', 'confirmed'])->hideOnIndex(),
            PasswordField::make('password_confirmation')
                ->label('Confirmar contraseña')
                ->rules(['min:6'])->hideOnIndex()->canBeSaved(false),
        ];
    }

    public function getTranslations(): array
    {
        return [
            'singular' => 'Usuario',
            'plural' => 'Usuarios',
        ];
    }

    /**
     * Validaciones para actualizar el modelo.
     *
     * @return array
     */
    public static function updateRules($request)
    {
        $rules = self::rules($request);
        $rules['users_password'] = 'nullable|min:6|confirmed';
        $rules['users_password_confirmation'] = 'exclude_if:users_password,null|min:6';

        return $rules;
    }

    /**
     * Validaciones para actualizar mi cuenta.
     *
     * @return array
     */
    public static function accountRules($request)
    {
        $rules = self::updateRules($request);
        unset($rules['users_email']);

        return $rules;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'lastname_2',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Obtiene los logins con redes.
     */
    public function social()
    {
        return $this->hasMany(UserSocial::class);
    }

    /**
     * Guarda un modelo pero antes encrypta la contraseña si es necesario.
     */
    public function save(array $options = [])
    {
        if ($this->isDirty('password')) {
            $this->password = Hash::make($this->password);
        }

        parent::save($options);
    }
}
