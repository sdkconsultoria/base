@extends('base::back.layouts.app')

@section('title', $model->getTranslate('create') )

@section('content')
    <?= Base::breadcrumb([
        $model->getRoute('index') => $model->getLabel('plural'),
        $model->getRoute('show', $model->getKeyId()) => $model->getLabel('singular'),
        $model->getTranslate('edit')
        ]) ?>


    <div class="">
        {{-- <?= Base::settings($model); ?> --}}
        @if (method_exists($model, 'imagesTypesModel'))
            <div x-data="{ modal_image_type: false }">
                @php
                    $imageTypeModel = \Sdkconsultoria\Base\Models\Common\Image\ImageType::createEmpty();
                @endphp
                {{-- <?= $image_type = $model->imagesTypesModel()?> --}}
                <button @click="modal_image_type = true" class="btn btn-primary mb-3" type="button" name="button">{{$imageTypeModel->getTranslate('create')}}</button>
                <?= Base::popUp([
                    'id' => 'modal_image_type'
                ]) ?>
                @include('base::default.ajax.create', ['id' => 'modal_image_type', 'view' => 'base::back.image-types.', 'model' => $imageTypeModel])
                <?= Base::popUpFinish() ?>
            </div>
        @endif
    </div>

    <form action="{{$model->getRoute('update', $model->getKeyId())}}" method="post">
        @csrf
        @method('PUT')
        @include($view . '_form')
        <button class="btn btn-primary" type="submit" name="button"> {!! $model->getTranslate('edit') !!} </button>
    </form>
@endsection
