@extends('base::back.layouts.widget.central')

@section('central')
    <p class="text-center text-gray-500 fancy">@lang('auth.reset')</p>


    @if (session('status'))
    <div class="alert alert-info shadow-lg mb-1">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{session('status')}}</span>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

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

        <button type="submit" class="btn btn-primary mt-2 w-full">
            {{__('auth.send_password')}}
        </button>
    </form>
@endsection
