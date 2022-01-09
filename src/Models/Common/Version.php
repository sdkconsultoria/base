<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Version extends BaseModel
{
    /**
     * Sets up the relation.
     * @return MorphTo
     */
    public function versionable()
    {
        return $this->morphTo();
    }

    /**
     * Return the versioned model.
     * @return Model
     */
    public function getModel()
    {
        $model = $this->versionable_type::where('id', $this->versionable_id)->first();
        $model->unguard();
        $model->fill(json_decode($this->model_data, true));
        $model->exists = true;
        $model->reguard();

        return $model;
    }

    /**
     * Revert to the stored model version make it the current version.
     *
     * @return Model
     */
    public function revert()
    {
        $model = $this->getModel();

        if ($this->type == 'local') {
            unset($model->{$model->getCreatedAtColumn()});
            unset($model->{$model->getUpdatedAtColumn()});

            if (method_exists($model, 'getDeletedAtColumn')) {
                unset($model->{$model->getDeletedAtColumn()});
            }
            $model->save();

            return $model;
        }

        $model = self::where('id', json_decode($this->model_data, true)['child_version'])->first();
        $model->revert();
    }
}
