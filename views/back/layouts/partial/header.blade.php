<header class="flex justify-between items-center py-4 px-6 border-b-4 border-primary">
    <div class="flex items-center">
        <button x-on:click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
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
                    <li class="hover-bordered"><a>Claro</a></li>
                    <li class="hover-bordered"><a>Obscuro</a></li>
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
