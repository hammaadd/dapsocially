<section>
    <div class="w-full relative">
        <img src="{{asset('assets/Banner.jpg')}}" alt="">
        <div class=" absolute h-full w-full top-0">
            <nav class="flex flex-wrap overflow-hidden max-w-7xl mx-auto py-3">

                <div class="w-full overflow-hidden lg:w-1/3 xl:w-1/3">
                    <!-- Column Content -->
                    <a href="{{route('homepage')}}" class="logo">
                        <img src="{{asset('assets/logo.png')}}" class=" w-56" alt="DapSocially Logo">
                    </a>
                </div>

                <div class="w-full overflow-hidden lg:w-2/3 xl:w-2/3 flex items-center justify-end">
                    <!-- Column Content -->
                    <div class="flex items-center justify-between">
                        <!-- Column Content -->
                        <a href="/" class="nav-item">Home</a>
                        <a href="{{route('events')}}" class="nav-item">Events</a>
                        <a href="{{route('add-venue')}}" class="nav-item">Venue</a>
                        <a href="#" class="nav-item">Get Started</a>
                    </div>
                    <a href="{{route('signin')}}" class="btn-login">Login</a>
                    <form action="#" class=" w-44">
                        <div class="relative rounded-xl">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-blue-550 text-xl">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" name="search" class="search-input" placeholder="Search Here"/>
                        </div>
                    </form>
                </div>

            </nav>
            <div class="flex flex-wrap overflow-hidden max-w-7xl mx-auto h-5/6">
                <div class="w-full md:w-1/2 overflow-hidden flex justify-center text-white flex-col pl-5">
                    <h2 class="font-bold text-4xl uppercase">Dapsocially locations wall</h2>
                    <p class=" text-2xl">FREE</p>
                    <p class="text-3xl font-bold">SOCIAL MEDIA FEED</p>
                    <p class="text-2xl font-light text-gray-300"><span class="font-normal">DAPSOCIALLY</span> is a simple way to collect all your events
                        and venues social media post into a single amazing
                        social media feed.
                    </p>
                    <div class="pt-10">
                        <a href="{{route('add-event')}}" class="btn-add-event">ADD YOUR EVENT</a>
                        <a href="{{route('add-venue')}}" class="btn-add-venue">ADD YOUR VENUE</a>
                    </div>

                </div>
                <div class="w-full md:w-1/2 overflow-hidden flex items-center justify-center">
                    <div>
                        <img src="{{asset('assets/Group 511.png')}}" class=" max-w-lg mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
