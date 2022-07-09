@extends('base::back.layouts.widget.central')

@section('central')
    <p class="text-center text-gray-500 fancy">@lang('auth.before_continuing')</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="form-control w-full">
            <input type="text" name="password" placeholder="Contraseña" class="input input-bordered w-full" value="{{old('password')}}" required />
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

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{__('auth.password_confirm')}}
                </button>
            </div>
        </div>
    </form>
@endsection
