@extends('visitor.layout.visitorLayout')
@section('title','Homepage')
@section('headerExtra')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    $(document).ready(function(e) {

        $('#c').on('change', function() {

            var query = $(this).children("option:selected").val();

            $.ajax({
                url: "{{ route('filter.location') }}",
                method: 'GET',
                data: {
                    'q': query
                },
                dataType: 'json',
                success: function(data) {
                    $('#location')
                        .find('option')
                        .remove()
                        .end()

                    ;
                    // for (var i in data) {
                    //         $('#location').append('<option value=' + data[i] + '>' + data[i] + '</option>');
                    //     }
                    $('#location').append(data);

                }

            })
        });
    });
</script>
@endsection
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        {{-- Social Plateforms Section --}}
        <section class="py-5 lg:py-10 px-5">
            @if(!is_null($contents['platform']))

            <p class=" text-center uppercase font-medium text-xl">{{$contents['platform']->heading}}</p>
            <p class=" text-center text-gray-400 text-lg">Our Social feed can be used to collect social media content from various platforms like Twitter,<br>
                Instagram, Facebook and Tiktok to give you unlimited flow of user-generated content
            </p>
            @endif
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

        {{-- Search Form Section --}}
        <section class="lg:py-10 px-5">
            <form action="{{route('search')}}" method="POST">
                @csrf
                <div class="flex flex-wrap md:flex-nowrap md:space-x-8 lg:space-x-8 justify-center items-end">
                    <label for="keyword" class="w-full md:w-1/2 lg:w-4/12 py-2 lg:py-0">
                        SEARCH KEYWORD
                        <input type="text" name="keyword" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="#party">
                    </label>



                    <label for="location" class="w-full md:w-1/2 lg:w-4/12 py-2 lg:py-0">
                        LOCATION

                        <select name="location" id="l" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                        </select>
                    </label>

                    <label for="activity" class="w-full md:w-1/2 lg:w-3/12 py-2 lg:py-0">
                        City
                        <select name="c" id="c" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">

                            {{-- @foreach ($loc as $city)
                            <option value="{{$city}}">{{$city}}</option>
                            @endforeach --}}
                        </select>
                    </label>

                    {{-- <label for="activity" class=" w-3/12">
                        CITIY
                        <select name="city" id="" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                            @foreach ($locations as $location)
                            <option value="{{$location->city}}" >{{$location->city}}</option>
                    @endforeach
                    </select>
                    </label> --}}
                    <div class="w-full md:w-1/2 lg:w-2/12 xl:w-1/12 py-2 lg:py-0">
                        <input type="submit" value="SEARCH" class="w-full bg-blue-550 text-white py-1 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">
                    </div>
                </div>
            </form>
        </section>

        {{-- Venues Section --}}
        <section class="pt-5 lg:pt-4 pb-10 px-5">
            @if(!is_null($contents['venuec']))
            <h3 class="section-title relative text-xl font-medium">

                {{$contents['venuec']->heading}}
            </h3>
            <p>

                {!!$contents['venuec']->content!!}

            </p>
            @endif
            @if (count($venues) < 1) <div class="text-center w-full">
                <h3 class=" mt-6 text-red-600 text-center text-xl font-medium">NO VENUES FOUND <i class="fas fa-exclamation"></i></h3>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">


                    @foreach ($venues as $venue)
                    <div class="relative">
                        <img src="{{asset('Users/VenueImages/'.$venue->c_image)}}" class="h-72 lg:h-96 object-cover w-full" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 right-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($venue->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($venue->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($venue->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5">
                                <a href="{{route('socialwall.venue',$venue)}}" class="text-xl font-medium">{{$venue->venue_name}}</a>
                                <p>
                                    <span class="text-sm m-1">{{$venue->hashtag}}</span>

                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach



                </div>
                @endif
                @if($load_more_venues)
                <div class="pt-10 text-center">
                    <a href="{{route('venue')}}" class="text-blue-550 py-2 px-5 border-2 border-blue-550 rounded-3xl hover:text-white hover:bg-blue-550">VIEW ALL VENUES</a>
                </div>
                @endif
        </section>

        {{-- Events Section --}}
        <section class="py-5 lg:py-10 px-5">
            <div class="flex flex-wrap overflow-hidden justify-between">
                <div class="w-full md:w-3/4 pl-2">
                    @if(!is_null($contents['eventc']))
                    <h3 class="section-title relative text-xl font-medium">

                        {{$contents['eventc']->heading}}
                    </h3>
                    <p>

                        {!!$contents['eventc']->content!!}

                    </p>
                    @endif
                </div>
                <div class="w-full md:w-1/4 w- flex items-center justify-center md:justify-end pt-5 md:pt-0">
                    <a href="{{route('events')}}" class="bg-blue-550 text-white py-1.5 px-3 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">VIEW ALL EVENTS</a>
                </div>
            </div>
            @if (count($events) < 1) <div class="text-center w-full">
                <h3 class=" mt-6 text-red-600 text-center text-xl font-medium">NO EVENTS FOUND <i class="fas fa-exclamation"></i></h3>
                </div>

                @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">


                    @foreach ($events as $event)
                    <div class="relative">
                        <img src="{{asset('Users/EventImages/'.$event->c_image)}}" class="h-72 lg:h-96 object-cover w-full" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($event->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($event->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($event->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                                <div class="w-3/4">
                                    <a href="{{route('socialwall.event',$event)}}" class="text-xl font-medium">{{$event->event_name}}</a>
                                    <p><span class="text-sm m-1">{{$event->hashtag}}</span></p>
                                </div>
                                <div class="w-1/4 flex justify-end items-center">
                                    <a href="{{route('events')}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white">VIEW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                @endif
        </section>

        {{-- Trust Section --}}
        <section class="py-5 lg:py-10 px-5">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-1/2">
                    <img src="{{asset('assets/OBJECTS.jpg')}}" class="w-full max-w-sm mx-auto" alt="">
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center py-5 md:py-0">
                    <p class="text-xl font-medium pb-8 text-center md:text-left">
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