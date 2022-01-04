@section('partial_form')
    <?= Base::breadcrumb([ $model->getRoute('index') => $model->getLabel('plural'),  $model->getTranslate('create')]) ?>

    <div class="">
        <?= Base::settings($model); ?>
    </div>

    <form action="{{$model->getRoute('store')}}" method="post">
        @csrf
        @include($view . '_form')
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('create') !!} </button>
    </form>
@endsection
