@extends('visitor.layout.visitorLayout')
@section('title','Attach account')
@section('content')
@include('users.inc.nav')


<main class="bg-white min-h-600">
    <div class="max-w-6xl mx-auto p-5 md:p-8 lg:py-16">
        <div class="bg-gradient-to-tr from-blue-350 to-blue-450 w-full md:w-11/12 lg:w-3/4 mx-auto rounded-xl">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-1/2 p-5 md:p-8 lg:p-10 relative md:form-side">
                    <h3 class="text-white md:text-lg font-medium">Please attach atleast one social account to get started</h3>

                        <div class="pt-4 text-center">
                            <p class="text-gray-300 text-sm">Click on this</p>
                            <div class="pt-2 text-center">
                                {{-- <a href="{{route('attach.facebook')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/icons8_google.png')}}" class="mx-auto" alt="">
                                    </div>
                                </a> --}}
                                <a href="{{$url}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/icons8_facebook_2.png')}}" class="mx-auto" alt="">
                                        @if(Auth::user()->facebook())
                                            <div class="text-green-500" title="Account Attached">
                                                <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="white" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                        @endif
                                    </div>

                                </a>

                                {{-- <a href="{{route('attach.facebook')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/Insta@2x.png')}}" class="mx-auto w-5 h-5" alt="">

                                    </div>
                                </a> --}}
                                <a href="{{route('attach.twitter')}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/twitter@2x.png')}}" class="mx-auto w-5 h-5" alt="">
                                        @if(Auth::user()->twitter())
                                            <div class="text-green-500" title="Account Attached">
                                                <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="white" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <a href="{{$tt_url}}" class="mx-1">
                                    <div class="bg-white rounded-xl w-10 h-10 pt-2.5 inline-block">
                                        <img src="{{asset('assets/tiktok@2x.png')}}" class="mx-auto w-5 h-5" alt="">
                                        @if(Auth::user()->tiktok())
                                            <div class="text-green-500" title="Tiktok Attached">
                                                <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="white" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                {{-- <button type="button" onClick={(e) => {
                                    e.preventDefault();
                                    window.location.href='{SERVER_ENDPOINT_OAUTH}';
                                  }}>Continue with TikTok</button> --}}
                            </div>
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
                        <a href="#" class="bg-transparent text-white px-5 py-1.5 rounded-3xl border-2 border-white hover:bg-white hover:text-blue-550">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('users.inc.footer')
@endsection
