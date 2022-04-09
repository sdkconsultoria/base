<?php

namespace Sdkconsultoria\Base\Fields;

abstract class Field
{
    public $visible_on_index = true;
    public $visible_on_create = true;
    public $visible_on_update = true;
    public $visible_on_details = true;

    public static function make(){
        return new self;
    }
}
