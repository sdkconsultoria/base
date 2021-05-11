@extends('base::back.layouts.app')

@section('title', $model->getTranslate('create') )

@section('content')
    <?= Base::breadcrumb([ $model->getRoute('index') => $model->getLabel('plural'),  $model->getTranslate('create')]) ?>

    <form action="{{$model->getRoute('store')}}" method="post">
        @csrf
        @include($view . '_form')
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('create') !!} </button>
    </form>
@endsection
