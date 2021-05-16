<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Sdkconsultoria\Base\Traits\BaseModel as TBaseModel;
use Sdkconsultoria\Base\Traits\ImageTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Sdkconsultoria\Base\Models\Auth\UserSocial;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, TBaseModel, ImageTrait;
    use TwoFactorAuthenticatable;

    public const STATUS_DELETED = 0;
    public const STATUS_BLOCKED = 10;
    public const STATUS_DISABLED = 15;
    public const STATUS_CREATION = 20;
    public const STATUS_ACTIVE = 30;

    protected static $package = 'base';
    public static $keyId = 'id';

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
    public static function rules()
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
    public static function updateRules()
    {
        $rules = self::rules();
        $rules['users_password'] = 'nullable|min:6|confirmed';
        $rules['users_password_confirmation'] = 'exclude_if:users_password,null|min:6';
        return $rules;
    }


    /**
     * Validaciones para actualizar mi cuenta.
     *
     * @return array
     */
    public static function accountRules()
    {
        $rules = self::updateRules();
        unset($rules['users_email']);
        return $rules;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'lastname_2',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
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
