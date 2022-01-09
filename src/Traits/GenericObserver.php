<?php

namespace Sdkconsultoria\Base\Traits;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait GenericObserver
{
    public static function bootGenericObserver()
    {
        static::created(function ($model) {
            static::createHistory($model, 'create');
        });
        static::updated(function (Model $model) {
            static::createHistory($model, 'update');
        });
        static::deleted(function (Model $model) {
            static::createHistory($model, 'delete');
        });
    }

    protected static function createHistory($model, string $type, $values = false)
    {
        $history = new History();
        $history->user_id = Auth::user() ? Auth::user()->id : null;
        $history->model_id = $model->id ?? $model->role_id;
        $history->model_table = $model->getTable();
        $history->type = $type;
        $history->save();
    }
}
