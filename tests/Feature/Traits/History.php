<?php

namespace Sdkconsultoria\Base\Tests\Traits;

trait History
{
    public function testHistory()
    {
        $model = $this->model::factory()->create();
        $model2 = $this->model::factory()->make();
        $model->delete();
        $key = $this->attributes[0];
        $model->$key = $model2->$key;
        $model->save();
        $this->assertCount(3, $model->historyList());
    }
}
