@extends('base::default.show')

@section('model')
    <?= Base::details([
            'model' => $model,
            'attributes' => [
                'identifier',
                'translate.title',
                'translate.subtitle',
                'translate.description',
            ]
        ]) ?>
@endsection
