@extends('base::default.index')

@section('model')
    <?= Base::gridView([
            'model' => $model,
            'models' => $models,
            'attributes' => [
                'identifier',
                'translate.title',
                'translate.subtitle',
            ]
        ]) ?>
@endsection
