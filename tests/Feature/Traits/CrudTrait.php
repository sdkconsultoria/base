<?php

namespace Sdkconsultoria\Base\Tests\Traits;

/**
 *
 */
trait CrudTrait
{
    /**
     * Create an object.
     *
     * @return void
     */
    public function testCreate()
    {
        $model = $this->model::factory()->create();
        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
        ]);
    }

    /**
     * Update an object.
     *
     * @return void
     */
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

    /**
     * Delete an object.
     *
     * @return void
     */
    public function testDelete()
    {
        $model = $this->model::factory()->create();
        $model->delete();
        $this->assertSoftDeleted($model);
    }

    /**
     * Check the history of an object.
     *
     * @return void
     */
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
