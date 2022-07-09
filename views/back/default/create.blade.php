@extends('base::back.layouts.app')

@section('title', $model->getTranslation('create') )

@section('content')
    <?= Base::breadcrumb([ $model->getRoute('index') => $model->getTranslation('plural'),  $model->getTranslation('create')]) ?>

    <div id=app>
        <form-model
            :routes='{{json_encode($model->getIndexRoutes())}}'
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
            csrf="{{csrf_token()}}"
            :fields='{!! json_encode($model->getFields()) !!}'
            model_id="{{$model->id}}"
        />
    </div>
@endsection
