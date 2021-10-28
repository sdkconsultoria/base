@extends('base::default.show')

@section('model')
    <?= Base::details([
            'model' => $model,
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
