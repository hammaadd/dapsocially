@extends('visitor.layout.visitorLayout')
@section('title','Events')
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
@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">All Events</h2>
    </section>

    <section class="page-title bg-blue-550 h-80 bg-center bg-cover" style="background-image: url(assets/BG.png)">
        <div class="w-full md:w-4/5 lg:w-1/2 mx-auto flex flex-wrap overflow-hidden h-full">
            <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                <img src="{{asset('assets/Event Illustration.png')}}" alt="">
            </div>
            <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                <p class="text-white">
                    <span class="px-16 py-4 border-2 border-white text-2xl uppercase block w-1/2 text-center">Events</span><br>
                    Find the latest events updates or create events, concerts,
                    conferences, workshops, exhibitions and cultural events
                    in all cities of United States.
                </p>
            </div>
        </div>
    </section>

    <div class="bg-white py-4 shadow-md">
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

    <section class="py-10 max-w-7xl mx-auto">
        <form action="{{route('search.event')}}" method="POST">
            @csrf
            <div class="flex space-x-8 justify-center items-end">
                <label for="keyword" class=" w-4/12">
                    SEARCH KEYWORD
                    <input type="text" id="keyword" name="keyword" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md" placeholder="#party">
                </label>
                <label for="activity" class=" w-3/12">
                    City
                    <select name="c" id="c" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                        @foreach ($loc as $city)
                         <option value="{{$city}}" >{{$city}}</option>
                        @endforeach
                    </select>
                </label>
                <label for="location" class=" w-4/12">
                    LOCATION
                    <select name="location" id="location" class="w-full bg-white shadow-md border-1 border-gray-200 rounded-md">
                        @foreach ($locations as $location)

                                    <option value="{{$location}}" >{{$location}}</option>
                        @endforeach
                    </select>
                </label>

                <div class="lg:w-2/12 xl:w-1/12">
                    <input type="submit" value="SEARCH" class="w-full bg-blue-550 text-white py-1 border-2 border-blue-550 rounded-3xl cursor-pointer hover:text-blue-550 hover:bg-transparent">

                </div>
            </div>
        </form>

        <div class=" max-w-7xl mx-auto pt-10">
            <div class="masonry md:cols--3 lg:cols--4">
                @foreach ($events as $event)
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="{{asset('Users/EventImages/'.$event->c_image)}}" alt="Event Image">
                            {{-- <img src="{{asset('assets/fb.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt=""> --}}
                        </div>
                        <div class="pl-4 pt-2 pr-4 pb-2 ">
                            <h4>
                              <a href="{{route('facebook.posts',$event->id)}}">  <b>{{$event->event_name}}</b></a>
                            </h4>
                        </div>
                        <div class="pb-4 pl-4 pr-4">
                            <p>
                                {{$event->e_description}}
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('user/profile/'. App\Models\User::where('id','=',$event->created_by)->get()[0]->image)}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">{{App\Models\User::where('id','=',$event->created_by)->get()[0]->name}}</p>
                                    <p class="text-xs">{{App\Models\User::where('id','=',$event->created_by)->get()[0]->account_type}}</p>
                                </div>

                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2"> {{ date('h:i A', strtotime($event->start_time))}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/280?image=300" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/540?image=400" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/400?image=700" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/280?image=900" alt="Dummy Image">
                            <img src="{{asset('assets/fb.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/550?image=950" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/325?image=25" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/280?image=75" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/380?image=125" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/550?image=950" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/280?image=75" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/325?image=100" alt="Dummy Image">
                            <img src="{{asset('assets/fb.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/325?image=100" alt="Dummy Image">
                            <img src="{{asset('assets/fb.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/280?image=300" alt="Dummy Image">
                            <img src="{{asset('assets/Insta.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/540?image=400" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="masonry-item">
                    <div class="masonry-content">
                        <div class="relative">
                            <img class=" rounded-lg" src="https://picsum.photos/450/400?image=700" alt="Dummy Image">
                            <img src="{{asset('assets/tiktok.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                        </div>
                        <div class="p-4">
                            <p>
                                Ryan Reynolds teams up with Salma Hayek to save Samuel L. Jackson in The Hitman's Wife's Bodyguard!
                                Coming to Event Cinemas this June!
                            </p>
                        </div>
                        <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                            <div class="flex flex-wrap overflow-hidden justify-between items-center">
                                <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                                <div class="pl-2">
                                    <p class="font-medium">Account Username</p>
                                    <p class="text-xs">Premium Account</p>
                                </div>
                            </div>
                            <div>
                                <i class="far fa-clock"></i><span class="text-sm pl-2">12:34 PM</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="w-full text-center py-10">
                <a href="{{route('load.events')}}" class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Load More</a>
            </div>
        </div>
    </section>
</main>
@include('users.inc.footer')
@endsection
