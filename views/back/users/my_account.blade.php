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

    @if (session('sactum_token'))
        <?= Base::alert()->success(session('sactum_token')) ?>
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

    <div class="p-4 bg-white mb-5 shadow rounded-lg mt-3" x-data="{ tokenModal: false }">
        @php
            $tokens = $model->tokens;
        @endphp

        <div class="">
            <h3 class="text-90 uppercase tracking-wide font-bold text-sm py-4">@lang('base::models.token.plural')</h3>
            <button x-on:click="tokenModal = true" class="btn btn-primary mb-3" type="button" name="button">@lang('base::models.common.create', ['model' => 'Token'])</button>
        </div>

        <div x-show="tokenModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle md:w-6/12 sm:w-full">
                    <form class="" action="{{route('user.new-token')}}" method="post">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        @lang('base::models.common.create', ['model' => 'Token'])
                                    </h3>
                                    <?=
                                    Base::input([
                                        'required' => 'required',
                                        'name' => 'name',
                                    ])->setTranslate(__('base::models.common.name'))->prepend(Base::icon('document-text'))->label(false);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="btn btn-success">
                                @lang('base::app.common.save')
                            </button>
                            <button x-on:click="tokenModal = false" type="button" class="btn btn-danger mr-2">
                                @lang('base::app.common.cancel')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider font-bold">Nombre</th>
                                <th></th>
                            </thead>
                            @foreach ($tokens as $token)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$token->name}}</td>
                                    <td>
                                        <form
                                        data-title="{!!trans_choice('base::models.common.delete_question', 1, ['item' => 'Token'])!!}"
                                        data-confirm="@lang('base::models.common.delete', ['model' => 'Token'])"
                                        data-cancel="@lang('base::app.common.cancel')"
                                        class="form-question" method="POST" action="{{route('user.delete-token', $token->id)}}">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="h-5 w-5 mr-1" type="submit"> {!!Base::icon('trash')!!}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
