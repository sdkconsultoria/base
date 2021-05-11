@extends('base::back.layouts.empty')

@section('content')
<div class="p-3 min-h-full flex flex-colum flex-wrap content-center justify-center">
    <div class="lg:w-2/6 flex flex-col bg-white rounded-3xl p-10">
        <div class="flex flex-row justify-center">
            <?= Base::img('images/logo_sdk.png', ['width' => '30%']) ?>
        </div>
        @yield('central')
    </div>
</div>
@endsection
