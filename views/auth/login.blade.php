@extends('base::back.layouts.widget.central')

@section('central')
    <form class="" action="{{ route('login') }}" method="post" novalidate>
        @csrf
        <p class="text-center text-gray-500 fancy">@lang('auth.login_now')</p>

        <?=
        Base::input([
            'required' => 'required',
            'name' => 'email',
        ])->setTranslate(__('base::models.user.email'))->prepend(Base::icon('user'))->label(false);
        ?>

        <?=
        Base::input([
            'required' => 'required',
            'name' => 'password',
        ])->setTranslate(__('base::models.user.password'))->prepend(Base::icon('mail'))->passwordInput()->label(false);
        ?>

        <button class="w-full mt-1 btn btn-success" type="submit">{{__('auth.login')}}</button>
        <a href="{{route('register')}}" class="text-center w-full mt-2 btn btn-primary" type="button">@lang('auth.register')</a>
        <a href="{{ route('password.request') }}" class="text-center w-full mt-2 btn-outline-warning" type="button">{{__('auth.forgot')}}</a>

        <div class="mt-3 flex justify-center">
            <a class="tracking-wider text-white bg-blue-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold" href="{{route('social-auth', 'facebook')}}"> Facebook</a>
            <a class="tracking-wider text-white bg-red-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold"  href="{{route('social-auth', 'google')}}"> Google </a>
        </div>
    </form>
    @include('base::auth.sso')
@endsection
