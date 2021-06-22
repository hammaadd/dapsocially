@extends('visitor.layout.visitorLayout')
@section('title','My Venues')
@section('content')
@include('users.inc.nav')
<main>




    <section class="py-10 max-w-7xl mx-auto">
        <form action="{{route('search.my.venue')}}" method="POST">
            @csrf
            <div class="flex space-x-8 justify-center items-end">
                <label for="keyword" class=" w-4/12">
                    SEARCH KEYWORD
                    <input type="text" id="keyword" name="keyword" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="#party">
                </label>
                <label for="location" class=" w-4/12">
                    LOCATION
                    <select name="location" id="location" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                        @foreach ($locations as $location)

                                    <option value="{{$location->address}}" >{{$location->address}}</option>
                        @endforeach
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

        <div class=" max-w-7xl mx-auto pt-10">
            <section class="py-10">

                @if (count($venues) < 1)
                <div class="text-center w-full">  <h3 class=" mt-6  text-center text-xl font-medium">NO VENUES </h3></div>

                 @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8">


                    @foreach ($venues as $venue)
                    <div class="relative">
                        <img src="{{asset('Users/venueImages/'.$venue->c_image)}}" class="h-96 object-cover" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($venue->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($venue->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($venue->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                                <div class="w-3/4">
                                    <a href="#" class="text-xl font-medium">{{$venue->venue_name}}</a>
                                    <p><span class="text-sm m-1">{{$venue->hashtag}}</span></p>
                                </div>
                                <div class="w-1/4 flex justify-end items-center">
                                    <a href="{{route('edit.venue',$venue)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white mr-2">EDIT</a>

                                    <a href="{{route('delete.my.venue',$venue)}}" class="bg-white text-gray-900 py-1.5 px-4 rounded-3xl text-sm hover:bg-blue-550 hover:text-white ">DELETE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
                @endif
            </section>

            <div class="w-full text-center py-10">
                <a href="{{route('load.my.venues')}}" class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Load More</a>
            </div>
        </div>
    </section>
</main>
@include('users.inc.footer')
@endsection