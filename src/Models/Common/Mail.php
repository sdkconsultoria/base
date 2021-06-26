<?php

namespace Sdkconsultoria\Base\Models\Common;

use Sdkconsultoria\Base\Models\Model as BaseModel;
use Illuminate\Validation\Rule;

class Mail extends BaseModel
{
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
}
