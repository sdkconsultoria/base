@extends('base::back.layouts.app')

@section('title', $model->getTranslation('edit') )

@section('content')
    <?= Base::breadcrumb([
        $model->getRoute('index') => $model->getTranslation('plural'),
        $model->getRoute('view', $model->getKeyId()) => $model->getTranslation('singular'),
        $model->getTranslation('edit')
        ]) ?>


    <div id=app>
        <form-model
            :routes='{{json_encode($model->getIndexRoutes())}}'
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
            csrf="{{csrf_token()}}"
            :fields='{!! json_encode($model->getFields()) !!}'
            model_id="{{$model->id}}"
        >
            <input type="hidden" name="_method" value="PUT" />
        </form-model>
    </div>
@endsection
