@extends('base::default.show')


@section('model')
    <?= Base::details([
            'model' => $model,
            'attributes' => [
                'name',
                'lastname',
                'lastname_2',
                'email',
            ]
        ]) ?>
@endsection
