<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use Sdkconsultoria\Base\Http\Controllers\ResourceController;

class MailController extends ResourceController
{
    protected $model = \Sdkconsultoria\Base\Models\Common\Mail::class;
    protected $view = 'base::back.mail.';
}