@extends('base::back.layouts.app')

@section('title', $model->getTranslation('create') )

@section('content')
    <?= Base::breadcrumb([ $model->getRoute('index') => $model->getTranslation('plural'),  $model->getTranslation('create')]) ?>

    <div class="">
        <?= Base::settings($model); ?>
    </div>

    <form action="{{$model->getRouteApi('create')}}" method="post">
        {{-- @include($view . '_form') --}}
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslation('create') !!} </button>
    </form>
@endsection