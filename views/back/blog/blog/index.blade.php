@extends('base::back.layouts.app')

@section('title', $model->getFullTranslations()['plural'])

@section('content')
    <?= Base::breadcrumb([
        $model->getFullTranslations()['plural']
    ]) ?>
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
