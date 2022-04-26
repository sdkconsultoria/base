@extends('base::back.layouts.widget.central')

@section('central')
    <p class="text-center text-gray-500 fancy">@lang('auth.before_continuing')</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <?=
                Base::input([
                    'required' => 'required',
                    'name' => 'password',
                ])->setTranslate(__('core::models.user.password'))->prepend(Base::icon('lock-closed'))->passwordInput()->label(false);
                ?>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{__('auth.password_confirm')}}
                </button>
            </div>
        </div>
    </form>
@endsection
