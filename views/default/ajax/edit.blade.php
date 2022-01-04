@section('partial_form')
    <?= Base::breadcrumb([
        $model->getRoute('index') => $model->getLabel('plural'),
        $model->getRoute('show', $model->getKeyId()) => $model->getLabel('singular'),
        $model->getTranslate('edit')
        ]) ?>

    <form action="{{$model->getRoute('update', $model->getKeyId())}}" method="post">
        @csrf
        @method('PUT')
        @include($view . '_form')
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('edit') !!} </button>
    </form>
@endsection
