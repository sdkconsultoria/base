<header class="flex justify-between items-center py-4 px-6 border-b-4 border-primary">
    <div class="flex items-center">
        <button x-on:click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <div class="flex items-center">
        @php
            $user = auth()->user();
            $image = $user->image;
        @endphp
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button x-on:click="dropdownOpen = ! dropdownOpen" >
                <div class="avatar online placeholder">
                    <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
                        @if ($image)
                            <img src="{{$image}}" />
                        @else
                            <span class="uppercase">{{$user->name[0]}}{{$user->lastname[0]}}</span>
                        @endif
                    </div>
                </div>
            </button>

            <div x-show="dropdownOpen" x-on:click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

            <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 rounded-md overflow-hidden shadow-xl z-10">
                <ul class="menu bg-base-100 w-56 rounded-box">
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
