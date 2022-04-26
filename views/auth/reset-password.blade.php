@extends('core::back.layouts.widget.central')

@section('central')

    <p class="text-center text-gray-500 fancy">@lang('auth.reset')</p>

    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ request()->token }}">

            <?=
            Base::input([
                'required' => 'required',
                'name' => 'email',
                'value' => request()->email ?? old('email'),
                'readOnly' => 'readOnly',
            ])->setTranslate(__('core::models.user.email'))->prepend(Base::icon('mail'))->label(false);
            ?>

            <?=
            Base::input([
                'required' => 'required',
                'name' => 'password',
                'autofocus' => 'autofocus',
            ])->setTranslate(__('core::models.user.password'))->prepend(Base::icon('key'))->passwordInput()->label(false);
            ?>

            <?=
            Base::input([
                'required' => 'required',
                'name' => 'password_confirmation',
                'autocomplete' => 'new-password'
            ])->setTranslate(__('auth.password_confirm'))->prepend(Base::icon('key'))->passwordInput()->label(false);
            ?>

             <button type="submit" class="btn btn-primary mt-2 w-full">
                 {{__('auth.reset')}}
             </button>
        </form>
    </div>
@endsection
