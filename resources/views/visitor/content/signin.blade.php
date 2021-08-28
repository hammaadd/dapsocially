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
    <div class="w-full sm:w-64 bg-gradient-to-tr from-blue-250 to-blue-550 absolute top-0 left-0 h-screen z-10" x-show="nav" @click.away="nav = !nav" x-transition:enter="transition transform origin-top-left ease-out duration-300" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition transform origin-top-left ease-out duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75">
        <div class="text-right p-5">
            <i class="fas fa-times text-xl cursor-pointer text-white" @click=" nav = !nav "></i>
        </div>
        <ul class="text-center text-white">
            <li class="py-1"><a href="{{ route('homepage') }}" class="text-xl">Home</a></li>
            <li class="py-1"><a href="{{route('events')}}" class="text-xl">Events</a></li>
            <li class="py-1"><a href="{{route('venue')}}" class="text-xl">Venues</a></li>
            <li class="py-1"><a href="{{route('signin')}}" class="text-xl">Get Started</a></li>
            <li class="py-2">
                <a href="{{route('signin')}}" class="bg-white text-blue-550 md:text-lg uppercase px-6 py-1 border-2 border-white rounded-3xl hover:text-white hover:bg-transparent">LOGIN</a>
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
</nav>
<main class="bg-white min-h-600">
    <div class="max-w-6xl mx-auto p-5 md:p-8 lg:py-16">
        <div class="bg-gradient-to-tr from-blue-350 to-blue-450 w-full md:w-11/12 lg:w-3/4 mx-auto rounded-xl">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-1/2 p-5 md:p-8 lg:p-10 relative md:form-side">
                    <h3 class="text-white md:text-lg font-medium">Sign in to Your Account</h3>
                    <form action="{{ route('login') }}" method="POST" class="pt-3">
                        @csrf
                        <input type="email" class="w-full bg-white rounded-3xl border-gray-200 px-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                        <div class="my-3 relative rounded-3xl" x-data="{ ptoggle: true}">
                            <input :type="ptoggle ? 'password' : 'text'" name="password" class="block w-full rounded-3xl border-gray-200 px-4 @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Password" />
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center">
                                <span class="text-lg">
                                    <i class="text-blue-550 fas" @click=" ptoggle = !ptoggle" :class="{'fa-eye-slash': !ptoggle, 'fa-eye':ptoggle }"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-between items-center">
                            <label class="flex items-center">
                                <input type="checkbox" class="text-blue-550 border-blue-550 focus:ring-blue-550" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <span class="block ml-2 text-white cursor-pointer">Remember Me</span>
                            </label>
                            <div>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-white font-medium">Forget Password?</a>
                                @endif
                            </div>
                        </div>
                        <div class="pt-3 flex flex-wrap flex-col space-y-2 md:flex-row items-center justify-between">
                            <button type="submit" class="bg-blue-550 text-white uppercase px-5 py-1.5 rounded-3xl hover:text-blue-550 hover:bg-white">Login</button>
                            @if (Route::has('password.request'))
                            <a href="{{route('signup')}}" class="bg-blue-550 text-white uppercase px-5 py-1.5 rounded-3xl hover:text-blue-550 hover:bg-white">Signup</a>
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
                            <a href="{{route('login.twitter')}}" class="mx-1">
                                <div class="bg-white rounded-xl w-10 h-10 pt-3 inline-block">
                                    <img src="{{asset('assets/icons8_twitter_1.png')}}" class="mx-auto" alt="">
                                </div>
                            </a>
                            <a href="{{url('login/instagram')}}" class="mx-1">
                                <div class="bg-white rounded-xl w-10 h-10 pt-3 inline-block">
                                    <img src="data:image/jpeg;base64,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" class="mx-auto" height="70" width="20" alt="">
                                </div>
                            </a>
                        </div>
                        <!-- <a href="{{route('signup')}}" class="text-white font-medium">Or Signup Here!</a> -->
                    </div>

                </div>
                <div class="w-full md:w-1/2 p-5 md:p-8 lg:p-10">
                    <h3 class="text-white md:text-lg font-medium">Get In Touch</h3>
                    <p class="text-gray-300 text-base">
                        If you would like to find out more about how we can help you, please give us a call or drop us an email.
                    </p>
                    <ul class="pt-4 text-white">
                        <li class="py-1"><a href="tel:3145015100" class="hover:text-gray-300"><i class="fas fa-phone-alt pr-1"></i> (314) 501-5100</a></li>
                        <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-gray-300"><i class="fas fa-envelope pr-1"></i> admin@dapsocially.com</a></li>
                        <li class="py-1"><a href="#" class="hover:text-gray-300"><i class="fas fa-map-marked-alt pr-1"></i> 11 Brady Circle, Ste.300 St.Louis, MO 63114</a></li>
                    </ul>
                    <div class="pt-4 text-center md:text-left">
                        <a href="{{route('contact.support')}}" class="bg-transparent text-white px-5 py-1.5 rounded-3xl border-2 border-white hover:bg-white hover:text-blue-550">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('visitor.inc.footer')
@endsection
