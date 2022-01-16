<?php

namespace Sdkconsultoria\Base\Tests\Traits;

trait SimpleCrud
{
    public function testCreate()
    {
        $model = $this->model::factory()->create();
        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
        ]);
    }


    public function testUpdate()
    {
        $model = $this->model::factory()->create();
        $model2 = $this->model::factory()->make();

        foreach ($this->attributes as $value) {
            $model->$value = $model2->$value;
        }

        $model->save();

        foreach ($this->attributes as $value) {
            $this->assertEquals($model->$value, $model2->$value);
        }
    }


    public function testDelete()
    {
        $model = $this->model::factory()->create();
        $model->delete();
        $this->assertSoftDeleted($model);
    }
}
