@extends('visitor.layout.visitorLayout')
@section('title','Venues')
@section('headerExtra')
<link rel="stylesheet" href="{{ asset('css/masonry.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>

$(document).ready(function (e) {

    $('#c').on('change', function () {
        var query=$(this).children("option:selected").val();

        $.ajax({
   url:"{{ route('filter.location') }}",
   method:'GET',
   data:{'q':query},
   dataType:'json',
   success:function(data)
   {
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
@include('users.inc.nav')
<main>
    {{-- <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">All Venues</h2>
    </section> --}}
    {{-- <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
        <ol class="list-reset flex text-grey-dark">
          <li><a href="{{route('homepage')}}" class="text-blue-550 font-bold">Home</a></li>
          <li><span class="mx-2">/</span></li>
          <li>venues</li>
        </ol>
      </nav> --}}
    <section class="page-title bg-blue-550 md:h-80 bg-center bg-cover" style="background-image: url(assets/BG.png)">
        <div class="w-full md:w-4/5 lg:w-1/2 mx-auto flex flex-wrap overflow-hidden h-full p-4 md:p-0">
            <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                <img src="{{asset('assets/Event Illustration.png')}}" alt="" class="w-1/2 sm:w-56 mx-auto">
            </div>
            <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                <p class="text-white pt-3 md:pt-0">
                    <span class="px-16 py-2 md:py-4 border-2 border-white text-lg md:text-2xl uppercase block text-center">Venues</span><br>
                    Find the latest venues updates or create venues for concerts,
                    conferences, workshops, exhibitions and cultural events
                    in all cities of United States.
                </p>
            </div>
        </div>
    </section>

    <div class="bg-white p-4 shadow-md">
        <div class=" max-w-7xl mx-auto">
            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/fb.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#event</span>
                </label>
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/twitter.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#event2021</span>
                </label>
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/fb.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#partynight</span>
                </label>
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/Insta.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#dapsocially</span>
                </label>
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/twitter.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#peterrabit2</span>
                </label>
                <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                    <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                        <img src="{{asset('assets/Insta.png')}}" class="w-6 h-6 mx-auto" alt="">
                    </div>
                    <span class="px-3">#partytonight</span>
                </label>
            </div>
        </div>
    </div>

    <section class="px-4 py-10 max-w-7xl mx-auto">
        <form action="{{route('search.venue')}}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <label for="keyword" class="w-full">
                    SEARCH KEYWORD
                    <input type="text" id="keyword" name="keyword" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="#party">
                </label>
                <label for="activity" class="w-full">
                    City
                    <select name="city" id="c" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">


                    </select>
                </label>
                <label for="location" class="w-full">
                    LOCATION
                    <select name="location" id="l" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">

                    </select>
                </label>

                <div class="w-full flex items-end">
                    <input type="submit" value="SEARCH" class="w-full bg-blue-550 text-white py-1 border-2 border-blue-550 rounded-md min-h-40 cursor-pointer hover:text-blue-550 hover:bg-transparent">
                </div>
            </div>
        </form>

        <div class=" max-w-7xl mx-auto pt-10">
            {{-- <div class="masonry md:cols--3 lg:cols--4"> --}}
            <div class="clearfix" id="fh5co-board" data-columns>

                @if(count($venues)==0)
                <h3 class=" mt-6 text-red-600 text-center text-xl font-medium">NO VENUES FOUND <i class="fas fa-exclamation"></i></h3>
                @endif

                @foreach ($venues as $venue)
                <div class="item">
                    <div class="">
                        <a href="{{route('socialwall.venue',$venue)}}" class="fh5co-board-img">
                            <div class="relative">
                                <img class=" rounded-lg w-full object-cover" src="{{asset('Users/VenueImages/'.$venue->c_image)}}"
                                    alt="Venue Image">

                            </div>
                        </a>
                    </div>
                    <div class="px-4 pt-4">
                        <h4 class="font-bold pb-1">
                            <a href="{{route('socialwall.venue',$venue)}}">{{$venue->venue_name}}</a>
                        </h4>
                        <p>
                            {{$venue->v_description}}
                        </p>
                    </div>
                    <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                        <div class="flex flex-wrap overflow-hidden justify-between items-center">
                            <img src="{{asset('user/profile/'. App\Models\User::where('id','=',$venue->created_by)->get()[0]->image)}}"
                                class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                            <div class="pl-2">
                                <p class="font-medium">
                                    {{App\Models\User::where('id','=',$venue->created_by)->get()[0]->name}}</p>
                                <p class="text-xs">
                                    {{App\Models\User::where('id','=',$venue->created_by)->get()[0]->account_type}}
                                </p>
                            </div>
                        </div>
                        <div>
                            <i class="far fa-clock"></i><span class="text-sm pl-1">
                                {{ date('h:i A', strtotime($venue->start_time))}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($load_more)
            <div class="w-full text-center py-10">
                <a href="{{route('load.venues')}}" class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Load More</a>
            </div>
            @endif
        </div>
    </section>
</main>
@include('users.inc.footer')
@endsection
@section('bodyExtra')
    <script src="{{ asset('js/salvattore.min.js') }}"></script>
@endsection
