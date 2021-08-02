@extends('visitor.layout.visitorLayout')
@section('title','My Accounts')
@section('content')
@include('users.inc.nav')
<main>
    <nav class="p-5">
        <ol class="list-reset flex text-grey-dark">
          <li><a href="{{route('homepage')}}" class="text-blue-550 font-bold">Home</a></li>
          <li><span class="mx-2">/</span></li>
          <li>My Account</li>

        </ol>
      </nav>
<div class="max-w-6xl mx-auto">
    <section class="py-5 px-5 max-w-7xl mx-auto">
        <div class=" max-w-7xl mx-auto">
            <section class="pb-10">
                <h3 class="section-title relative text-xl font-medium">MY VENUES</h3>

                @if (count($venues) < 1)
                <div class="text-center w-full">  <h3 class=" mt-6  text-center text-xl font-medium">NO VENUES </h3></div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-10 lg:pt-16">


                    @foreach ($venues as $venue)
                    <div class="relative">
                        <img src="{{asset('Users/VenueImages/'.$venue->c_image)}}" class="h-96 object-cover" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($venue->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($venue->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($venue->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-col md:flex-row flex-wrap items-center">
                                <div class="w-full md:w-3/4">
                                    <a href="#" class="text-xl font-medium">{{$venue->venue_name}}</a>
                                    <p><span class="text-sm m-1">{{$venue->hashtag}}</span></p>
                                </div>
                                <div class="w-full md:w-1/4 flex justify-end items-center pt-2 md:pt-0">
                                    <a href="{{route('edit.venue',$venue)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white mr-2">EDIT</a>

                                    <a href="{{route('delete.my.venue',$venue)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white ">DELETE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
                @endif
                <div class="pt-10 text-center">
                    <a href="{{route('my.venues')}}" class="text-blue-550 py-2 px-5 border-2 border-blue-550 rounded-3xl hover:text-white hover:bg-blue-550">VIEW MY ALL VENUES</a>
                </div>
            </section>

            {{-- Events Section --}}
            <section class="py-5 lg:py-10">
                <div class="flex flex-wrap flex-col md:flex-row overflow-hidden">
                    <div class="w-full md:w-3/4 pl-2">
                        <h3 class="section-title relative text-xl font-medium">MY EVENTS</h3>

                    </div>
                    <div class="w-full md:w-1/4 pt-5 md:pt-0 flex items-center justify-center md:justify-end">
                        <a href="{{route('my.events')}}" class="bg-blue-550 text-white py-1.5 px-3 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">VIEW MY ALL EVENTS</a>
                    </div>
                </div>
                @if (count($events) < 1)
                <div class="text-center w-full">  <h3 class=" mt-6  text-center text-xl font-medium">NO EVENTS </h3></div>

                 @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">


                    @foreach ($events as $event)
                    <div class="relative">
                        <img src="{{asset('Users/EventImages/'.$event->c_image)}}" class="h-72 md:h-96 object-cover w-full" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($event->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($event->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($event->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-col md:flex-row flex-wrap items-center">
                                <div class="w-full md:w-3/4">
                                    <a href="{{route('socialwall.event',$event)}}" class="text-xl font-medium">{{$event->event_name}}</a>
                                    <p><span class="text-sm m-1">{{$event->hashtag}}</span></p>
                                </div>
                                <div class="w-full md:w-1/4 flex justify-end items-center pt-2 md:pt-0">
                                    <a href="{{route('edit.event',$event)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white mr-2">EDIT</a>

                                    <a href="{{route('delete.my.event',$event)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white ">DELETE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
                @endif
            </section>
        </div>
    </section>
</div>
</main>
@include('users.inc.footer')
@endsection
@section('bodyExtra')

<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
   @if(Session::has('message'))
     toastr.options =
     {
       "closeButton" : true,
       "progressBar" : true
     }
         toastr.success("{{ session('message') }}");
 @endif
 @if(Session::has('error'))
     toastr.options =
     {
       "closeButton" : true,
       "progressBar" : true
     }
         toastr.warning("{{ session('error') }}");
 @endif
</script>
@endsection
