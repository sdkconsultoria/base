@extends('base::back.layouts.app')

@section('title', $model->getLabel('my_account'))

@section('content')
    <?= Base::breadcrumb([ $model->getLabel('my_account')]) ?>

    @if (session('status') == "two-factor-authentication-disabled")
        <?= Base::alert()->success(__('auth.two_factor_disabled')) ?>
    @endif

    @if (session('status') == "two-factor-authentication-enabled")
        <?= Base::alert()->success(__('auth.two_factor_enabled')) ?>
    @endif

    <form enctype="multipart/form-data" action="{{route('save.my_account')}}" method="post" class="p-4 bg-white mb-5 shadow rounded-lg mt-3">
        @csrf
        <div class="flex">
            <div class="w-1/2">
                <?= $model->input('name') ?>
                <?= $model->input('lastname') ?>
                <?= $model->input('lastname_2') ?>
                <?= $model->input('password')->passwordInput() ?>
                <?= $model->input('password_confirmation')->passwordInput() ?>
                <?= $model->input('photo')->imageInput([], 'users_profile_photo') ?>
                <button class="btn btn-primary mt-3" type="submit" name="button"> @lang('base::app.common.update') </button>
            </div>
            <div class="w-1/2 flex flex-row flex-wrap justify-center items-center">
                @if ($model->image)
                    {!! $model->image->image('medium', ['id' => 'users_profile_photo']) !!}
                @else
                    <img id="users_profile_photo" src="/images/profile.png" alt="">
                @endif
            </div>
        </div>
    </form>

    <div class="p-4 bg-white mb-5 shadow rounded-lg mt-3">
        <h3 class="text-90 uppercase tracking-wide font-bold text-sm py-4">@lang('auth.two_factor')</h3>
        <p> @lang('auth.two_factor_add') </p>

        <form class="" action="/user/two-factor-authentication" method="post">
            @csrf
            @if (auth()->user()->two_factor_secret)
                <br>
                @method('DElETE')

                <div class="pb-5">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>

                <div>
                    <h3> <strong>@lang('auth.recovery_codes')</strong> </h3>
                    <ul>
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                            <li>{{ $code }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="btn btn-default btn-danger mt-3">@lang('auth.disable')</button>
            @else
                <button type="submit" class="btn btn-default btn-primary mt-3" name="button">@lang('auth.enable')</button>
            @endif
        </form>
    </div>
    <div class="p-4 bg-white mb-5 shadow rounded-lg mt-3">
        <h3 class="text-90 uppercase tracking-wide font-bold text-sm py-4">@lang('auth.social_link')</h3>
        <a class="tracking-wider text-white bg-blue-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold" href="{{route('social-auth', 'facebook')}}"> Facebook</a>
        <a class="tracking-wider text-white bg-red-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold"  href="{{route('social-auth', 'google')}}"> Google </a>
    </div>

@endsection
