@extends('visitor.layout.visitorLayout')
@section('title','About us')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        <h3 class="text-xl font-medium text-center uppercase mt-5">About Us</h3>
        {{-- Social Plateforms Section --}}
        <section class="py-5 px-5 lg:py-10">
            <p class=" text-center uppercase font-medium text-xl">{{$about_us->heading}}</p>
            <p class=" text-center text-lg mt-5">
                {!!$about_us->content!!}
            </p>

            <div class=" grid grid-cols-2 md:grid-cols-4 gap-5 w-max max-w-3xl mx-auto py-5">
                <div class="text-center w-24">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/fb.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Facebook</p>
                </div>
                <div class="text-center w-24">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/Insta.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Instagram</p>
                </div>
                <div class="text-center w-24">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/twitter.png')}}" class="h-10 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Twitter</p>
                </div>
                <div class="text-center w-24">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/tiktok.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">TikTok</p>
                </div>
            </div>
        </section>




    </main>
    @include('visitor.inc.footer')
</section>
@endsection
