@extends('base::back.layouts.app')

@section('title', $model->getTranslation('plural'))

@section('content')
    <?= Base::breadcrumb([
        $model->getTranslation('plural')
    ]) ?>

    <div class="mb-2">
        <a type="button" href="{{$model->getRoute('create')}}" class="btn btn-primary"> {!! $model->getTranslation('create') !!} </a>
    </div>

    <div id=app>
        <grid-view
            :routes={{json_encode($model->getIndexRoutes())}}
            :fields="{{json_encode($model->getIndexFields())}}"
            :filters={{json_encode($model->getParseSearchFilters())}}
            :translations='{!! json_encode($model->getFullTranslations()) !!}'
        />
    </div>
@endsection
