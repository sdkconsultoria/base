@extends('core::back.layouts.widget.central')

@section('central')
    <form class="" action="{{ route('register') }}" method="post" novalidate>
       @csrf
       <p class="text-center text-gray-500 fancy">@lang('auth.register')</p>
       <?=
           Base::input([
               'required' => 'required',
               'name' => 'email',
           ])->setTranslate(__('core::models.user.email'))->prepend(Base::icon('mail'))->label(false);
       ?>

       <?=
           Base::input([
               'required' => 'required',
               'name' => 'name',
           ])->setTranslate(__('core::models.user.name'))->prepend(Base::icon('user'))->label(false);
       ?>

       <?=
           Base::input([
               'required' => 'required',
               'name' => 'lastname',
           ])->setTranslate(__('core::models.user.lastname'))->prepend(Base::icon('users'))->label(false);
       ?>

       <?=
           Base::input([
               'required' => 'required',
               'name' => 'lastname_2',
           ])
           ->setTranslate(__('core::models.user.lastname_2'))
           ->prepend(Base::icon('users'))
           ->label(false);
       ?>

       <?=
           Base::input([
               'required' => 'required',
               'name' => 'password',
           ])
           ->setTranslate(__('core::models.user.password'))
           ->prepend(Base::icon('key'))
           ->label(false)
           ->passwordInput();
       ?>

       <?=
           Base::input([
               'required' => 'required',
               'name' => 'password_confirmation',
           ])
           ->validate(false)
           ->setTranslate(__('core::models.user.password_confirmation'))
           ->prepend(Base::icon('key'))
           ->label(false)
           ->passwordInput();
       ?>
       <button class="w-full text-center mt-2 btn btn-success" type="submit">@lang('auth.create')</button>
       <a class="w-full text-center mt-2 btn btn-primary" type="button" href="{{route('login')}}">@lang('auth.log_in')</a>

       <div class="mt-3 flex justify-center">
            <a class="tracking-wider text-white bg-blue-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold" href="{{route('social-auth', 'facebook')}}"> Facebook</a>
            <a class="tracking-wider text-white bg-red-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold"  href="{{route('social-auth', 'google')}}"> Google </a>
        </div>
    </form>
    @include('core::auth.sso')
@endsection
