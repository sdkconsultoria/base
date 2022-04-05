@extends('base::back.layouts.app')

@section('title_tab', __('base::attributes.schedule.edit'))

@section('content')
    <div id=app>
        <grid-view
            :routes={{json_encode($model->getIndexRoutes())}}
            :fields="[
                'id',
                'title',
                'subtitle'
            ]"
            :filters={{json_encode($model->getParseSearchFilters())}}
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
        />
    </div>
@endsection
