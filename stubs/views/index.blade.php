@extends('core::default.index')

@section('model')
    <?= Base::gridView([
            'model' => $model,
            'models' => $models,
            'attributes' => [

            ]
        ]) ?>
@endsection
