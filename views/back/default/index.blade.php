@extends('base::back.layouts.app')

@section('title', $model->getTranslation('plural'))

@section('content')
    <?= Base::breadcrumb([
        $model->getTranslation('plural')
    ]) ?>

    <div id=app>
        <grid-view
            create_route="{{$model->getRoute('create')}}"
            :routes={{json_encode($model->getIndexRoutes())}}
            :fields="{{json_encode($model->getIndexFields())}}"
            :filters={{json_encode($model->getParseSearchFilters())}}
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
        />
    </div>
@endsection
