@extends('core::default.show')


@section('model')
    <?= Base::details([
            'model' => $model,
            'attributes' => [
            ]
        ]) ?>
@endsection
