<header class="flex justify-between items-center py-2 px-6 border-b-4 border-primary">
    <div class="flex items-center">
        <button x-on:click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            {!!Base::icon('view-list', ['class' => 'h-6'])!!}
        </button>
    </div>

    @php
        $user = auth()->user();
        $image = $user->image;
    @endphp
    <div class="flex justify-end flex-1 px-2">
        <div class="flex items-stretch">
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost rounded-btn">{!!Base::icon('sun', ['class' => 'h-5'])!!}</label>
                <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                    @foreach (config('base.themes') as $index => $theme)
                    <li class="hover-bordered"><a href="{{request()->fullUrlWithQuery(['theme' => $index])}}">{{$theme}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost rounded-btn">
                    <div class="avatar online placeholder">
                        <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
                            @if ($image)
                                <img src="{{$image}}" />
                            @else
                                <span class="uppercase">{{$user->name[0]}}{{$user->lastname[0]}}</span>
                            @endif
                        </div>
                    </div>
                </label>
                <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                    <li class="hover-bordered"><a href="{{route('profile')}}">Mi Cuenta</a></li>
                    <li class="hover-bordered"><a href="#" onclick="document.getElementById('form-logout').submit()" >@lang('auth.close')</a></li>
                </ul>
                <form id="form-logout" action="{{route('logout')}}" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>
