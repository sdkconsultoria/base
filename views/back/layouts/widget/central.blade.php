@extends('base::back.layouts.empty')

@section('content')
<div class="p-3 min-h-full flex flex-colum flex-wrap content-center justify-center drop-shadow-2xl">
    <div class="lg:w-2/6 flex flex-col bg-neutral-content rounded-3xl p-10">
        <div class="flex flex-row justify-center">
            <img src="{{ asset('img/logo.svg') }}" width="40%" class="h-24" />
        </div>
        @yield('central')
    </div>
</div>
@endsection
