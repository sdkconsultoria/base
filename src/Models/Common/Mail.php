<?php

namespace Sdkconsultoria\Base\Models\Common;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Illuminate\Validation\Rule;
use Sdkconsultoria\Base\Jobs\ProcessMail;

class Mail extends BaseModel
{
    protected static $package = 'base';

    /**
     * Validaciones para crear el modelo.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'mails_name' => ['required'],
            'mails_email' => ['required', Rule::unique('mails', 'email'), 'email'],
        ];
    }

    /**
     * Guarda un corre pero lo sincroniza con el servidor.
     */
    public function save(array $options = [])
    {
        ProcessMail::dispatch($this);
        parent::save($options);
    }
}
