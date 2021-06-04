@extends('visitor.layout.visitorLayout')
@section('title','Homepage')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        {{-- Social Plateforms Section --}}
        <section class="py-10">
            <p class=" text-center uppercase font-medium text-xl">COLLECT Amazing Content From DIFFERENT Social Media Platforms</p>
            <p class=" text-center text-gray-400 text-lg">Our Social feed can be used to collect social media content from various platforms like Twitter,<br>
                Instagram, Facebook and Tiktok to give you unlimited flow of user-generated content
            </p>
            <div class=" flex flex-wrap overflow-hidden justify-around max-w-3xl mx-auto py-5">
                <div class="text-center">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/fb.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Facebook</p>
                </div>
                <div class="text-center">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/Insta.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Instagram</p>
                </div>
                <div class="text-center">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/twitter.png')}}" class="h-10 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">Twitter</p>
                </div>
                <div class="text-center">
                    <div class="bg-white shadow rounded-full w-20 h-20 mx-auto grid place-items-center">
                        <img src="{{asset('assets/tiktok.png')}}" class="h-11 w-11" alt="">
                    </div>
                    <p class="mt-3 uppercase">TikTok</p>
                </div>
            </div>
        </section>

        {{-- Search Form Section --}}
        <section class="py-10">
            <form action="#">
                <div class="flex space-x-8 justify-center items-end">
                    <label for="keyword" class=" w-4/12">
                        SEARCH KEYWORD
                        <input type="text" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="Search Here">
                    </label>
                    <label for="location" class=" w-4/12">
                        LOCATION
                        <select name="" id="" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                            <option>All Locations</option>
                            <option>United States</option>
                            <option>United Kingdom</option>
                            <option>Australia</option>
                            <option>New Zealand</option>
                        </select>
                    </label>
                    <label for="activity" class=" w-3/12">
                        ACTIVITY
                        <select name="" id="" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                            <option>Select Activity</option>
                            <option>Activity 1</option>
                            <option>Activity 2</option>
                            <option>Activity 3</option>
                        </select>
                    </label>
                    <div class="lg:w-2/12 xl:w-1/12">
                        <input type="submit" value="SEARCH" class="w-full bg-blue-550 text-white py-1 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">
                    </div>
                </div>
            </form>
        </section>

        {{-- Venues Section --}}
        <section class="pt-4 pb-10">
            <h3 class="section-title relative text-xl font-medium">VENUES</h3>
            <p>
                Discover the best things to do & events in United States. explore concerts, meetups,<br>
                open mics, art shows, music events and a lot more.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">
                <div class="relative">
                    <img src="{{asset('assets/Alain-Ducasse-scaled.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 right-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5">
                            <a href="#" class="text-xl font-medium">Palace Of Auburn Hills</a>
                            <p>
                                <span class="text-sm m-1">#restaurant</span>
                                <span class="text-sm m-1">#restaurants</span>
                                <span class="text-sm m-1">#restaurantparty2021</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/main-bar-at-tir-na-nog.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 right-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">02</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5">
                            <a href="#" class="text-xl font-medium">Cafe Show Seoul</a>
                            <p>
                                <span class="text-sm m-1">#bars</span>
                                <span class="text-sm m-1">#bar</span>
                                <span class="text-sm m-1">#barparty2021</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/216506068.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 right-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">03</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5">
                            <a href="#" class="text-xl font-medium">The Hotel Experience</a>
                            <p>
                                <span class="text-sm m-1">#hotel</span>
                                <span class="text-sm m-1">#hotels</span>
                                <span class="text-sm m-1">#hotelparty2021</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-10 text-center">
                <a href="#" class="text-blue-550 py-2 px-5 border-2 border-blue-550 rounded-3xl hover:text-white hover:bg-blue-550">VIEW ALL VENUES</a>
            </div>
        </section>

        {{-- Events Section --}}
        <section class="py-10">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-3/5 pl-2">
                    <h3 class="section-title relative text-xl font-medium">EVENTS</h3>
                    <p>
                        Discover the best things to do & events in United States. explore concerts, meetups,<br>
                        open mics, art shows, music events and a lot more.
                    </p>
                </div>
                <div class="w-full md:w-2/5 flex items-center justify-end">
                    <a href="#" class="bg-blue-550 text-white py-1.5 px-3 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">VIEW ALL EVENTS</a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">
                <div class="relative">
                    <img src="{{asset('assets/Flexi_CT_9-1-d973734e.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">Squash Junior Tournament</a>
                                <p><span class="text-sm m-1">Squash Open Cube Dallas</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/private-parties.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">Guitar Solo & Dance</a>
                                <p><span class="text-sm m-1">La Terazza</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/1024px-beach_volley_8143063908.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">Beach Volleyball Cup IF3</a>
                                <p><span class="text-sm m-1">IF3 Hall</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/unnamed.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">UCI Road World Champ...</a>
                                <p><span class="text-sm m-1">Rose Bowl (Pasadena, CA)</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/Maroon-5-2018-web-optimised-1000.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">Mardon 5 Live</a>
                                <p><span class="text-sm m-1">Neal S Blaisdell Arena</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="{{asset('assets/150923151159-greecerunning11-super-169.jpg')}}" class="h-96 object-cover" alt="">
                    <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                        <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-base">MAY</p>
                            <p class="text-base">2021</p>
                        </div>
                        <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                            <div class="w-3/4">
                                <a href="#" class="text-xl font-medium">Greece Running Marathon</a>
                                <p><span class="text-sm m-1">Greece Marathon</span></p>
                            </div>
                            <div class="w-1/4 flex justify-end items-center">
                                <a href="#" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- Trust Section --}}
        <section class="py-10">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-1/2">
                    <img src="{{asset('assets/OBJECTS.jpg')}}" class="lg:max-w-sm" alt="">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <p class="text-xl font-medium pb-8">
                        A SOCIAL FEED TRUSTED BY THE WORLD'S LEADING BRANDS
                    </p>
                    <div class="grid grid-cols-3 gap-4">
                        <img src="{{asset('assets/Google.jpg')}}" class="py-4" alt="">
                        <img src="{{asset('assets/Adobe.jpg')}}" class="py-4" alt="">
                        <img src="{{asset('assets/Marvelapp.jpg')}}" class="py-4" alt="">
                        <img src="{{asset('assets/Microsoft.jpg')}}" class="py-4" alt="">
                        <img src="{{asset('assets/Dell.jpg')}}" class="py-4" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('visitor.inc.footer')
</section>
@endsection
