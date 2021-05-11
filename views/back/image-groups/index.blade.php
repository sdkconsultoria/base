@extends('base::default.index')

@section('model')
    <?= Base::gridView([
            'model' => $model,
            'models' => $models,
            'attributes' => [
                'translate.name',
            ]
        ]) ?>
@endsection
