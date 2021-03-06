@extends('visitor.layout.visitorLayout')
@section('title','My Events')

@section('content')
@include('users.inc.nav')
<main>

    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">My Events</h2>
    </section>

    <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
        <ol class="list-reset flex text-grey-dark">
          <li><a href="{{route('homepage')}}" class="text-blue-550 font-bold">Home</a></li>
          <li><span class="mx-2">/</span></li>
          <li>My Events</li>
        </ol>
      </nav>
    <section class="p-4 max-w-7xl mx-auto">
        <form action="{{route('search.my.event')}}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <label for="keyword" class="w-full">
                    SEARCH KEYWORD
                    <input type="text" id="keyword" name="keyword" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="#party">
                </label>
                <label for="activity" class="w-full">
                    City
                    <select name="c" id="c" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">

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

        <div class=" max-w-7xl mx-auto pt-5">
            <section class="pb-10">

                @if (count($events) < 1)
                {{-- <div class="text-center w-full">  <h3 class=" mt-6  text-center text-xl font-medium">NO EVENTS </h3></div> --}}
                <h3 class=" mt-6 text-red-600 text-center text-xl font-medium">NO EVENTS FOUND <i class="fas fa-exclamation"></i></h3>
                 @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 pt-8">


                    @foreach ($events as $event)
                    <div class="relative">
                        <img src="{{asset('Users/EventImages/'.$event->c_image)}}" class="h-96 object-cover" alt="">
                        <div class="absolute w-full h-full bg-black bg-opacity-60 top-0 left-0">
                            <div class="absolute top-0 left-10 bg-black bg-opacity-70 text-white text-center px-3 py-2">
                                <p class="text-2xl font-bold">{{Illuminate\Support\Str::substr($event->start_date, 8, 9)}}</p>
                                <p class="text-base">{{DateTime::createFromFormat('!m', Illuminate\Support\Str::substr($event->start_date, 6, -3))->format('F')}}</p>
                                <p class="text-base">{{Illuminate\Support\Str::substr($event->start_date, 0,4)}}</p>
                            </div>
                            <div class="left-0 right-0 bottom-4 absolute text-white px-5 flex flex-wrap items-center">
                                <div class="w-3/4">
                                    <a href="#" class="text-xl font-medium">{{$event->event_name}}</a>
                                    <p><span class="text-sm m-1">{{$event->hashtag}}</span></p>
                                </div>
                                <div class="w-1/4 flex justify-end items-center">
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

            {{-- @if ($load_more_events)
            <div class="w-full text-center py-10">
                <a href="{{route('load.my.events')}}" class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Load More</a>
            </div>
            @endif --}}
        </div>
    </section>
</main>
@include('users.inc.footer')
@endsection
@section('headerExtra')
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

