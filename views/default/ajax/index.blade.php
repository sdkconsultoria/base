@section('partial_form')
    <?= Base::breadcrumb([$model->getLabel('plural')]) ?>

    <div class="mb-2">
        <a type="button" href="{{$model->getRoute('create')}}" class="btn btn-primary"> {!! $model->getTranslate('create') !!} </a>
    </div>

    @yield('model')
@endsection
