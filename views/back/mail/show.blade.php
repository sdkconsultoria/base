@extends('base::default.show')

@section('model')
    <?= Base::details([
            'model' => $model,
            'attributes' => [
                'name',
                'email',
            ]
        ]) ?>
@endsection
