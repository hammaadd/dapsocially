<header>
    <nav class="bg-gradient-to-tr from-blue-250 to-blue-550 py-2 relative shadow-md" x-data="{ nav: false}">
        <div class="max-w-7xl mx-auto flex flex-wrap overflow-hidden items-center justify-between flex-row-reverse md:flex-row px-5">
            <button class="text-white text-2xl focus:outline-none" @click=" nav = !nav ">
                <i class="fas fa-bars"></i>
            </button>
            <a href="#">
                <img src="{{asset('assets/logo.png')}}" class="w-44 md:w-56 md:pl-10" alt="DapSocially Logo">
            </a>
            <div class="flex flex-wrap items-center cursor-pointer">
                <img src="{{asset('user/profile/'.Auth::user()->image)}}" class="w-12 h-12 rounded-full object-contain bg-white avatar" alt="">
                <div class="text-white pl-2">
                   <a href="{{route('profile')}}"> <p class="font-medium">{{Auth::user()->name}}</p>
                    <p class="text-xs">Premium Account</p></a>
                </div>
            </div>
        </div>
        <div class="w-full sm:w-64 bg-gradient-to-tr from-blue-250 to-blue-550 absolute top-0 left-0 h-screen"
            x-show="nav"
            @click.away="nav = !nav"
            x-transition:enter="transition transform origin-top-left ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition transform origin-top-left ease-out duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75">
            <div class="text-right p-5">
                <i class="fas fa-times text-xl cursor-pointer text-white" @click=" nav = !nav " ></i>
            </div>
            <ul class="text-center text-white">
                <li class="py-1"><a href="#" class="text-xl">Home</a></li>
                <li class="py-1"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="text-xl">My Account</a></li>
                <li class="py-1"><a href="#" class="text-xl">Add Event</a></li>
                <li class="py-1"><a href="#" class="text-xl">Add Venue</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
            <hr class="w-4/5 mx-auto my-3 border-gray-400">
            <ul class="text-gray-300 text-center">
                <li class="py-1"><a href="tel:3045015100" class="hover:text-white"><i class="fas fa-phone-alt pr-1"></i> (304) 501-5100</a></li>
                <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-white"><i class="fas fa-envelope pr-1"></i> admin@dapsocially.com</a></li>
            </ul>
            <div class="pt-3 text-center">
                <a href="#" class="mx-1"><i class="fab fa-facebook-f social-link"></i></a>
                <a href="#" class="mx-1"><i class="fab fa-twitter social-link"></i></a>
                <a href="#" class="mx-1"><i class="fab fa-instagram social-link"></i></a>
            </div>
        </div>
    </nav>
</header>
