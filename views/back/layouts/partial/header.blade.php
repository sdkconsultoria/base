<header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
    <div class="flex items-center">
        <button x-on:click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <div class="flex items-center">
        <!-- <div x-data="{ notificationOpen: false }" class="relative">
            <button x-on:click="notificationOpen = ! notificationOpen" class="flex mx-4 text-gray-600 focus:outline-none">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div x-show="notificationOpen" x-on:click="notificationOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

            <div x-show="notificationOpen" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-10" style="width:20rem;">
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2">
                    <img class="h-8 w-8 rounded-full object-cover mx-1" src="" alt="avatar">
                    <p class="text-sm mx-2">
                        <span class="font-bold" href="#">Sara Salah</span> replied on the <span class="font-bold text-indigo-400" href="#">Upload Image</span> artical . 2m
                    </p>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-indigo-600 -mx-2">
                    <img class="h-8 w-8 rounded-full object-cover mx-1" src="" alt="avatar">
                    <p class="text-sm mx-2">
                        <span class="font-bold" href="#">Slick Net</span> start following you . 45m
                    </p>
                </a>
            </div>
        </div> -->

        <div x-data="{ dropdownOpen: false }"  class="relative">
            <button x-on:click="dropdownOpen = ! dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                @php
                    $user = auth()->user();
                    $image = $user->image;

                    if ($image) {
                        $image = $image->url('thumbnail');
                    } else {
                        $image = '/images/profile.png';
                    }

                @endphp
                <img class="h-full w-full object-cover" src="{{$image}}" alt="Your avatar">
            </button>

            <div x-show="dropdownOpen" x-on:click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

            <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                <a href="{{route('my_account')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">@lang('base::models.user.my_account')</a>
                <form id="form-logout" action="{{route('logout')}}" method="post">
                    @csrf
                </form>
                <a href="#" onclick="document.getElementById('form-logout').submit()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">@lang('auth.close')</a>
            </div>
        </div>
    </div>
</header>
