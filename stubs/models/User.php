<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Sdkconsultoria\Core\Models\Traits\BaseModel as TraitBaseModel;
use Sdkconsultoria\Core\Models\Traits\ImageTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Sdkconsultoria\Base\Models\Auth\UserSocial;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use ImageTrait;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use TraitBaseModel;

    public const STATUS_DELETED = 0;
    public const STATUS_BLOCKED = 10;
    public const STATUS_DISABLED = 15;
    public const STATUS_CREATION = 20;
    public const STATUS_ACTIVE = 30;

    /**
     * Obtiene los atributos por los cuales que se puede buscar
     * @return array
     */
    public function getFiltersAttribute()
    {
        return [
            'name' => [
                'column' => [
                    'name',
                    'lastname',
                    'lastname_2',
                ],
            ],
            'email',
            'status' => [
                'type' => 'dropdown',
                'options' => $this->getStatus()
            ]
        ];
    }

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    public static function rules($request)
    {
        return [
            'users_name' => 'required',
            'users_lastname' => 'required',
            'users_email' => 'required|email',
            'users_password' => 'required|min:6|confirmed',
            'users_password_confirmation' => 'min:6',
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
        parent::save($options);
    }
}
