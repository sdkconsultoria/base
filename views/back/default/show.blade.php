@extends('base::back.layouts.app')

@section('title', $model->getTranslation('showed'))

@section('content')
    <?= Base::breadcrumb([$model->getRoute('index') => $model->getTranslation('plural'), $model->getTranslation('showed')]) ?>
    <div class="mb-2 flex flex-row">
        <a type="button" href="{{ $model->getRoute('update', $model->getKeyId()) }}" class="btn btn-primary">
            {!! $model->getTranslation('edit') !!} </a>
        {{-- <form
        data-title="{{ $model::getTranslate('delete_question') }}"
        data-confirm="{{ $model::getTranslate('delete') }}"
        data-cancel="{{ __('base::app.common.cancel') }}"
        class="form-question" method="POST" action="{{ $model::getRoute('destroy', $model->getKeyId()) }}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button class="btn btn-danger ml-2" type="submit"> {{$model::getTranslate('delete')}}</button>
        </form> --}}

    </div>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($model->getFields() as $field)
                                <tr>
                                    <th class="text-gray-700"> {{$field['label']}} </th>
                                    <td> {{ $model->{$field['name']} }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @yield('model')
@endsection
