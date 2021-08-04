<section>
    <div class="w-full relative">
        <img src="{{asset('assets/Banner.jpg')}}" alt="" class="hidden lg:block lg:h-screen">
        <div class="lg:absolute h-auto lg:h-full w-full top-0 bg-gradient-to-tr from-blue-250 to-blue-550 lg:to-transparent lg:from-transparent lg:bg-transparent">
            <nav class="flex flex-wrap overflow-hidden max-w-7xl mx-4 xl:mx-auto py-3 justify-between items-center">

                <div class="overflow-hidden lg:w-1/3 xl:w-1/3">
                    <!-- Column Content -->
                    <a href="{{ route('homepage') }}" class="logo">
                        <img src="{{ asset('assets/logo.png') }}" class=" w-56" alt="DapSocially Logo">
                    </a>
                </div>

                <div class="overflow-hidden lg:w-2/3 xl:w-2/3 hidden lg:flex items-center justify-end">
                    <!-- Column Content -->
                    <div class="flex items-center justify-between">
                        <!-- Column Content -->
                        <a href="/" class="nav-item {{Request::is('/')?'nav-item-active':''}}">Home</a>
                        <a href="{{ route('events') }}" class="nav-item">Events</a>
                        <a href="{{ route('venue') }}" class="nav-item">Venue</a>
                        <a href="{{ route('signup') }}" class="nav-item">Get Started</a>
                    </div>
                    @if (!Auth::user())
                        <a href="{{ route('signin') }}" class="btn-login">Login</a>
                    @elseif (Auth::user())
                        <a href="{{ route('my.account') }}" class="btn-login">My Account</a>
                    @endif

                    <form action="#" class=" w-44">
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-blue-550 text-xl">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" name="search" class="search-input" placeholder="Search Here" />
                        </div>
                    </form>
                </div>
                <div class="flex overflow-hidden items-center justify-end lg:hidden" x-data="{ nav: false}">
                    <button class="text-white text-2xl focus:outline-none" @click=" nav = !nav ">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="w-full sm:w-64 bg-gradient-to-tr from-blue-250 to-blue-550 absolute top-0 right-0 h-screen z-10"
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
                            <li class="py-1"><a href="/" class="nav-item text-xl font-normal {{Request::is('/')?'nav-item-active':''}}">Home</a></li>
                            <li class="py-1"><a href="{{route('events')}}" class="nav-item text-xl font-normal">Events</a></li>
                            <li class="py-1"><a href="{{route('venue')}}" class="nav-item text-xl font-normal">Venue</a></li>
                            <li class="py-1"><a href="#" class="nav-item text-xl font-normal">Get Started</a></li>
                            <li class="py-1">
                                @if (!Auth::user())
                                <a href="{{route('signin')}}" class="btn-login">Login</a>
                                @elseif (Auth::user())
                                <a href="{{route('my.account')}}" class="btn-login">My Account</a>
                                @endif
                            </li>
                        </ul>
                        <hr class="w-4/5 mx-auto my-3 border-gray-400">
                        <ul class="text-gray-300 text-center">
                            <li class="py-1"><a href="tel:3145015100" class="hover:text-white"><i class="fas fa-phone-alt pr-1"></i> (314) 501-5100</a></li>
                            <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-white"><i class="fas fa-envelope pr-1"></i> admin@dapsocially.com</a></li>
                        </ul>
                        <div class="pt-3 text-center">
                            <a href="#" class="mx-1"><i class="fab fa-facebook-f social-link"></i></a>
                            <a href="#" class="mx-1"><i class="fab fa-twitter social-link"></i></a>
                            <a href="#" class="mx-1"><i class="fab fa-instagram social-link"></i></a>
                        </div>
                    </div>
                </div>

            </nav>
            <div class="flex flex-wrap overflow-hidden max-w-7xl mx-auto lg:h-5/6">
                <div class="w-full lg:w-1/2 overflow-hidden flex justify-center items-center lg:items-start text-white flex-col px-5 py-10 lg:py-0">
                    <h2 class="font-bold text-4xl uppercase text-center lg:text-left">{{ (App\Models\Content::where('key','dapintro')->first())->heading}}</h2>

                    <p class="text-2xl font-light text-gray-300 text-center lg:text-left"> {!! (App\Models\Content::where('key','dapintro')->first())->content!!}
                    </p>
                    <div class="pt-5 lg:pt-10 flex flex-col sm:flex-row">
                        <a href="{{route('add-event')}}" class="btn-add-event w-52">ADD YOUR EVENT</a>
                        <a href="{{route('add-venue')}}" class="btn-add-venue mt-5 sm:mt-0 w-52">ADD YOUR VENUE</a>
                    </div>

                </div>
                <div class="w-full lg:w-1/2 overflow-hidden flex items-center justify-center px-5 pb-10 lg:pb-0">
                    <div class="px-5">
                        <img src="{{asset('assets/Group 511.png')}}" class="w-full max-w-lg mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
