@extends('core::back.layouts.widget.central')

@section('central')
    <div class="col-md-8">
        <div class="card">
            <h1 class="text-center">  @lang('auth.two_factor') </h1>

            <div class="card-body">
                <p class="text-center">
                    @lang('auth.enter_code')
                </p>

                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <?=
                        Base::input([
                            'required' => 'required',
                            'name' => 'code',
                            'autofocus' => 'autofocus',
                        ])->setTranslate(__('core::models.user.code'))->prepend(Base::icon('key'))->passwordInput()->label(false);
                    ?>

                    <div class="mb-0 form-group row">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="mt-3 card">
            <h1 class="text-center">@lang('auth.two_factor_recovery_code')</h1>

            <div class="card-body">
                <p class="text-center">
                    @lang('auth.enter_recovery')
                </p>

                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <?=
                        Base::input([
                            'required' => 'required',
                            'name' => 'recovery_code',
                            'autofocus' => 'autofocus',
                        ])->setTranslate(__('core::models.user.recovery_code'))->prepend(Base::icon('key'))->passwordInput()->label(false);
                    ?>

                    <div class="mb-0 form-group row">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
