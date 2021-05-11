@extends('base::back.layouts.app')

@section('title', $model->getLabel('plural'))

@section('content')
    <?= Base::breadcrumb([$model->getLabel('plural')]) ?>

    <div class="mb-2">
        <a type="button" href="{{$model->getRoute('create')}}" class="btn btn-primary"> {!! $model->getTranslate('create') !!} </a>
    </div>

    @yield('model')
@endsection
