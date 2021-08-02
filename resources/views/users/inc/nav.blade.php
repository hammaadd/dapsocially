<header>
    <nav class="bg-gradient-to-tr from-blue-250 to-blue-550 py-2 relative shadow-md" x-data="{ nav: false}">
        <div class="w-full max-w-7xl mx-auto flex flex-wrap items-center justify-between flex-row-reverse md:flex-row px-5">
            <button class="text-white text-2xl focus:outline-none" @click=" nav = !nav ">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{route('homepage')}}">
                <img src="{{asset('assets/logo.png')}}" class="w-44 md:w-56 md:pl-10" alt="DapSocially Logo">
            </a>
            <div class=" relative" x-data="{ isOpen: false}">
                <div class="hidden md:flex flex-wrap overflow-hidden items-center cursor-pointer" @click=" isOpen = !isOpen ">
                    @auth
                        <img src="{{asset('user/profile/'.Auth::user()->image)}}" class="w-12 h-12 rounded-full object-contain bg-white avatar" alt="">
                        <div class="text-white pl-2">
                            <a href="javascript:void(0);"> <p class="font-medium">{{Auth::user()->name}}</p>
                             <p class="text-xs">{{Auth::user()->account_type}}</p></a>
                         </div>
                    @endauth

                    @guest
                        <img src="https://ui-avatars.com/api/?name=Guest?background=F3f3f3" class="w-12 h-12 rounded-full object-contain bg-white avatar" alt="">
                        <div class="text-white pl-2">
                            <a href="javascript:void(0);"> <p class="font-medium">GUEST</p>
                             <p class="text-xs" title="Account Type">FREE</p></a>
                         </div>
                    @endguest
                   
                </div>
                <ul
                    x-show="isOpen"
                    @click.away="isOpen = false"
                    x-transition:enter="transition transform origin-top-right ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-75"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition transform origin-top-right ease-out duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-75"
                    class="absolute bg-white shadow overflow-hidden rounded-xl w-60 mt-2 py-1 right-0 top-full z-20">
                    @auth
                    <li class="border-b border-green-150 px-3 py-1">
                        <a href="{{ route('profile') }}" class="">
                            <i class="fas fa-user text-blue-550"></i>
                            <span class="ml-2">Profile</span>
                        </a>
                    </li>
                    <li class="border-b border-green-150 px-3 py-1">
                        <a href="{{ route('my.account') }}" class="">
                            <i class="fas fa-home text-blue-550"></i>
                            <span class="ml-2">My Account</span>
                        </a>
                    </li>
                    
                    <li class=" px-3 py-1">
                        <a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="">
                            <i class="fas fa-sign-out-alt text-blue-550"></i>
                            <span class="ml-2">Logout</span>
                        </a>
                    </li>
                    @endauth
                    @guest
                    <li class="border-b border-green-150 px-3 py-1">
                        <a href="{{ route('signin') }}" class="">
                            <i class="fas fa-user text-blue-550"></i>
                            <span class="ml-2">Sign in</span>
                        </a>
                    </li>
                    <li class="border-b border-green-150 px-3 py-1">
                        <a href="{{ route('signup') }}" class="">
                            <i class="fas fa-home text-blue-550"></i>
                            <span class="ml-2">Register</span>
                        </a>
                    </li>
                
                    @endguest
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
        <div class="w-full sm:w-64 bg-gradient-to-tr from-blue-250 to-blue-550 absolute top-0 left-0 h-screen z-10"
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
                <li class="py-1"><a href="{{ route('homepage') }}" class="text-xl">Home</a></li>
                <li class="py-1"><a href="{{ route('profile') }}" class="text-xl">Profile</a></li>
                <li class="py-1"><a href="{{ route('my.account') }}"class="text-xl">My Account</a></li>
                <li class="py-1"><a href="{{ route('events') }}"class="text-xl">All Events</a></li>
                <li class="py-1"><a href="{{ route('venue') }}"class="text-xl">All Venues</a></li>
                <li class="py-1"><a href="{{route('add-event')}}" class="text-xl">Add Event</a></li>
                <li class="py-1"><a href="{{route('add-venue')}}" class="text-xl">Add Venue</a></li>
                <li class="py-1"><a href="{{ route('attach.social.account') }}" class="text-xl"> Attach Social Accounts</a></li>
                <li class="py-1"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="text-xl">Log Out</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
            <hr class="w-4/5 mx-auto my-3 border-gray-400">
            <ul class="text-gray-300 text-center">
                <li class="py-1"><a href="tel:3145015100" class="hover:text-white"><i class="fas fa-phone-alt pr-1"></i> {{ (App\Models\Shortcode::where('key','phone')->first())->content}}</a></li>
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
