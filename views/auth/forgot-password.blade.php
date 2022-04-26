@extends('base::back.layouts.widget.central')

@section('central')
    <p class="text-center text-gray-500 fancy">@lang('auth.reset')</p>


    @if (session('status'))
        {!! Base::alert()->success(session('status')) !!}
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <?=
        Base::input([
            'required' => 'required',
            'name' => 'email',
        ])->setTranslate(__('core::models.user.email'))->prepend(Base::icon('mail'))->label(false);
        ?>

        <button type="submit" class="btn btn-primary mt-2 text-center w-full">
            {{__('auth.send_password')}}
        </button>
    </form>
@endsection
