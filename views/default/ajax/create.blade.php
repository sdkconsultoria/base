
<form action="{{$model->getRoute('store')}}" method="post">
    <h2>{{$model->getTranslate('create')}}</h2>
    @csrf
    @include($view . '_form')
    <div class="sm:flex sm:flex-row-reverse">
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('create') !!} </button>
        <button  x-on:click="{{$id}} = false"  class="btn btn-danger mr-2" type="button" name="button"> @lang('base::app.common.cancel') </button>
    </div>
</form>
