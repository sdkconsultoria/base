@extends('base::back.layouts.app')

@section('title', $model->getTranslate('create') )

@section('content')
    <?= Base::breadcrumb([
        $model->getRoute('index') => $model->getLabel('plural'),
        $model->getRoute('show', $model->getKeyId()) => $model->getLabel('singular'),
        $model->getTranslate('edit')
        ]) ?>

    <?= Base::settings($model); ?>

    <form action="{{$model->getRoute('update', $model->getKeyId())}}" method="post">
        @csrf
        @method('PUT')
        @include($view . '_form')
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('edit') !!} </button>
    </form>
@endsection
