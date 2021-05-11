@extends('base::default.index')

@section('model')
    <?= Base::gridView([
            'model' => $model,
            'models' => $models,
            'attributes' => [
                'name',
                'lastname',
                'lastname_2',
                'email',
            ]
        ]) ?>
@endsection
