@extends('base::back.layouts.app')

@section('title', $model->getTranslation('showed'))

@section('content')
    <?= Base::breadcrumb([ $model->getRoute('index') => $model->getTranslation('plural'), $model->getTranslation('showed')]) ?>

    <div class="mb-2 flex flex-row">
        <a type="button" href="{{$model->getRoute('update', $model->getKeyId())}}" class="btn btn-primary"> {!!  $model->getTranslation('edit') !!} </a>

        {{-- <form
        data-title="{{ $model::getTranslate('delete_question') }}"
        data-confirm="{{ $model::getTranslate('delete') }}"
        data-cancel="{{ __('base::app.common.cancel') }}"
        class="form-question" method="POST" action="{{ $model::getRoute('destroy', $model->getKeyId()) }}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button class="btn btn-danger ml-2" type="submit"> {{$model::getTranslate('delete')}}</button>
        </form> --}}

    </div>

    @yield('model')
@endsection
