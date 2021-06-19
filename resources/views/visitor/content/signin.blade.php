@extends('visitor.layout.visitorLayout')
@section('title','Login')
@section('content')
<nav class="bg-gradient-to-tr from-blue-250 to-blue-550 py-2 relative shadow-md" x-data="{ nav: false}">
    <div class="max-w-7xl mx-auto flex flex-wrap overflow-hidden items-center justify-between flex-row-reverse md:flex-row px-5">
        <button class="text-white text-2xl focus:outline-none" @click=" nav = !nav ">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{route('homepage')}}">
            <img src="{{asset('assets/logo.png')}}" class="w-44 md:w-56 md:pl-10" alt="DapSocially Logo">
        </a>
        <a href="{{route('signup')}}" class="hidden md:block bg-white text-blue-550 md:text-lg uppercase px-6 border-2 border-white rounded-3xl hover:text-white hover:bg-transparent">SIGNUP</a>
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
            <li class="py-1"><a href="#" class="text-xl">Events</a></li>
            <li class="py-1"><a href="#" class="text-xl">Venues</a></li>
            <li class="py-1"><a href="#" class="text-xl">Get Started</a></li>
            <li class="py-2">
                <a href="#" class="bg-white text-blue-550 md:text-lg uppercase px-6 py-1 border-2 border-white rounded-3xl hover:text-white hover:bg-transparent">LOGIN</a>
            </li>
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
<main class="min-h-55 bg-gradient-to-tr from-blue-250 to-blue-550">
    <div class="max-w-6xl mx-auto p-5 md:p-8 lg:py-16">
        <div class="bg-gradient-to-tr from-blue-350 to-blue-450 w-full md:w-11/12 lg:w-3/4 mx-auto rounded-xl">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-1/2 p-5 md:p-8 lg:p-10 relative md:form-side">
                    <h3 class="text-white md:text-lg font-medium">Sign in to Your Account</h3>
                    <form action="{{ route('login') }}" method="POST" class="pt-3" >
                        @csrf
                        <input type="email" class="w-full bg-white rounded-3xl border-gray-200 px-4 @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required  autofocus placeholder="Email">
                        <div class="my-3 relative rounded-3xl" x-data="{ ptoggle: true}">
                            <input :type="ptoggle ? 'password' : 'text'" name="password" class="block w-full rounded-3xl border-gray-200 px-4 @error('password') is-invalid @enderror"
                            required autocomplete="current-password" placeholder="Password"/>
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center">
                                <span class="text-lg">
                                    <i class="text-blue-550 fas" @click=" ptoggle = !ptoggle" :class="{'fa-eye-slash': !ptoggle, 'fa-eye':ptoggle }"></i>
                                </span>
                            </div>
                        </div>
                        <label class="flex items-center mx-auto pl-3">
                            <input type="checkbox" class="text-blue-550 border-blue-550 focus:ring-blue-550" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}/>
                            <span class="block ml-2 text-white cursor-pointer">Remember Me</span>
                        </label>
                        <div class="pt-3 flex flex-wrap items-center justify-between">
                            <button type="submit" class="bg-blue-550 text-white uppercase px-5 py-1.5 rounded-3xl hover:text-blue-550 hover:bg-white">Login</button>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-white font-medium">Forget Password?</a>
                            @endif
                        </div>
                    </form>
                        <div class="pt-4 text-center">
                            <p class="text-gray-300 text-sm">Sign-in with</p>
                            <div class="pt-2 text-center">
                                <a href="{{route('login.google')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/icons8_google.png')}}" class="mx-auto" alt="">
                                    </div>
                                </a>
                                <a href="{{route('login.facebook')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/icons8_facebook_2.png')}}" class="mx-auto" alt="">
                                    </div>
                                </a>
                                <a href="{{route('login.google')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-3 inline-block">
                                        <img src="{{asset('assets/icons8_twitter_1.png')}}" class="mx-auto" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>

                </div>
                <div class="w-full md:w-1/2 p-5 md:p-8 lg:p-10">
                    <h3 class="text-white md:text-lg font-medium">Get In Touch</h3>
                    <p class="text-gray-300 text-base">
                        If you would like to find out more about how we can help you, please give us a call or drop us an email.
                    </p>
                    <ul class="pt-4 text-white">
                        <li class="py-1"><a href="tel:3045015100" class="hover:text-gray-300"><i class="fas fa-phone-alt pr-1"></i> (304) 501-5100</a></li>
                        <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-gray-300"><i class="fas fa-envelope pr-1"></i> admin@dapsocially.com</a></li>
                        <li class="py-1"><a href="#" class="hover:text-gray-300"><i class="fas fa-map-marked-alt pr-1"></i> 11 Brady Circle, Ste.300 St.Louis, MO 63114</a></li>
                    </ul>
                    <div class="pt-4">
                        <a href="#" class="bg-transparent text-white px-5 py-1.5 rounded-3xl border-2 border-white hover:bg-white hover:text-blue-550">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
