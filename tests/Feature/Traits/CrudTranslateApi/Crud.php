<?php

namespace Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi;

use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Utils;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Create;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\View;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\ViewAny;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Update;
use Sdkconsultoria\Base\Tests\Feature\Traits\CrudTranslateApi\Delete;

trait Crud
{
    use Utils;
    use Create;
    use View;
    use ViewAny;
    use Update;
    use Delete;
}
