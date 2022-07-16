@extends('base::back.layouts.widget.central')

@section('central')
    <form class="" action="{{ route('register') }}" method="post" novalidate>
       @csrf
       <p class="text-center text-gray-500 fancy">@lang('auth.register')</p>

       <div class="form-control w-full">
            <input type="text" name="email" placeholder="Correo Electronico" class="input input-bordered w-full" value="{{old('email')}}" required />
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
            <input type="text" name="name" placeholder="Nombre" class="input input-bordered w-full" value="{{old('name')}}" required />
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('name') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

        <div class="form-control w-full">
            <input type="text" name="lastname" placeholder="Apellido Materno" class="input input-bordered w-full" value="{{old('lastname')}}" required />
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('lastname') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

        <div class="form-control w-full">
            <input type="text" name="lastname_2" placeholder="Apellido Paterno" class="input input-bordered w-full" value="{{old('lastname_2')}}" required />
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('lastname_2') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

        <div class="form-control w-full">
            <input type="password" name="password" placeholder="Contraseña" class="input input-bordered w-full" value="{{old('password')}}" required />
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

        <div class="form-control w-full">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="input input-bordered w-full" value="{{old('password_confirmation')}}" required />
            <label class="label">
                <small class="text-error">
                    <ul>
                        @foreach ($errors->get('password_confirmation') as $error)
                        <li v-for="error in errors" :key="error"> {{$error}} </li>
                        @endforeach
                    </ul>
                </small>
            </label>
        </div>

       <button class="w-full mt-2 btn" type="submit">@lang('auth.create')</button>
       <a class="w-full mt-2 btn btn-primary" type="button" href="{{route('login')}}">@lang('auth.log_in')</a>

       <div class="mt-3 flex justify-center">
            <a class="tracking-wider text-white bg-blue-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold" href="{{route('social-auth', 'facebook')}}"> Facebook</a>
            <a class="tracking-wider text-white bg-red-500 px-5 py-2 text-sm rounded leading-loose mx-2 font-semibold"  href="{{route('social-auth', 'google')}}"> Google </a>
        </div>
    </form>
    @include('base::auth.sso')
@endsection
