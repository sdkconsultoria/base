@extends('base::default.index')

@section('model')
    <?= Base::gridView([
            'model' => $model,
            'models' => $models,
            'attributes' => [
                'name',
                'height',
                'width',
                'quality',
                'aspect',
                'fill',
                'transparency',
            ]
        ]) ?>
@endsection
