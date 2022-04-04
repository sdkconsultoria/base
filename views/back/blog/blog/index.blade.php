@extends('base::back.layouts.app')

@section('title_tab', __('base::attributes.schedule.edit'))

@section('content')
    <div id=app>
        <grid-view
            api="{{$model->getRouteApi('index')}}"
            :fields="[
                'id',
                'title',
                'subtitle'
            ]"
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
        />
    </div>
@endsection
