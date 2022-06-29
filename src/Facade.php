<?php

namespace Sdkconsultoria\Base;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'base';
    }
}
