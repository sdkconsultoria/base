@extends('base::back.layouts.widget.central')

@section('central')

    <p class="text-center text-gray-500 fancy">@lang('auth.reset')</p>

    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ request()->token }}">

            <div class="form-control w-full">
                <input type="text" name="email" placeholder="Correo" class="input input-bordered w-full" value="{{old('email')}}" required />
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
                <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="input input-bordered w-full" value="{{old('password_confirmation')}}" required />
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

             <button type="submit" class="btn btn-primary mt-2 w-full">
                 {{__('auth.reset')}}
             </button>
        </form>
    </div>
@endsection
