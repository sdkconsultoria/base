<?php

namespace Sdkconsultoria\Base\Tests\Traits;

trait Versionable
{
    public function testVersions()
    {
        $model = $this->model::factory()->create();
        $model2 = $this->model::factory()->make();
        $model3 = $this->model::factory()->make();

        foreach ($this->attributes as $value) {
            $model->$value = $model2->$value;
        }

        $model->save();
        $model->refresh();

        foreach ($this->attributes as $value) {
            $model->$value = $model3->$value;
        }

        $model->save();
        $model->refresh();
        $this->assertCount(2, $model->versions);
        $model->specificVersion(2)->revert();

        foreach ($this->attributes as $value) {
            $this->assertEquals($model->$value, $model3->$value);
        }
    }
}
