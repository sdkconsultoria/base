@extends('base::back.layouts.app')

@section('title_tab', __('base::attributes.schedule.edit'))

@section('content')
    <div id=app>
        <index-component
            api="{{route('api.blog.index')}}"
            :fields="[
                'title',
                'subtitle'
            ]"
        />
    </div>
@endsection
