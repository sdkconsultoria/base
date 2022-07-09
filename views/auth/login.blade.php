@extends('base::back.layouts.widget.central')

@section('central')
    <form action="{{ route('login') }}" method="post" novalidate>
        @csrf
        <div class="form-control w-full">
            <label class="input-group">
                <span>{!! Base::icon('mail', ['class' => 'h-3']) !!}</span>
                <input type="text" name="email" placeholder="Correo Electronico" class="input input-bordered w-full" value="{{old('email')}}" required/>
            </label>
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('email') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

        <div class="form-control w-full">
            <label class="input-group">
                <span>{!! Base::icon('lock-closed', ['class' => 'h-3']) !!}</span>
                <input type="password" name="password" placeholder="Contraseña" class="input input-bordered w-full" required />
            </label>
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('password') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

        <button class="w-full mt-1 btn" type="submit">{{__('auth.login')}}</button>
        <a href="{{route('register')}}" class="w-full mt-2 btn btn-primary" type="button">@lang('auth.register')</a>
        <a href="{{ route('password.request') }}" class="w-full mt-2 btn btn-outline btn-warning" type="button">{{__('auth.forgot')}}</a>

        <div class="mt-3 flex justify-center">
            <a class="tracking-wider text-white bg-blue-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold" href="{{route('social-auth', 'facebook')}}"> Facebook</a>
            <a class="tracking-wider text-white bg-red-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold"  href="{{route('social-auth', 'google')}}"> Google </a>
        </div>
    </form>
    @include('base::auth.sso')
@endsection
