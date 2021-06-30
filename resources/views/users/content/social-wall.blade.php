@extends('visitor.layout.visitorLayout')
@section('title','Social Wall')
@section('content')
<main class="relative" x-data="{ ad: false, card: true }">
    <section class="page-title bg-blue-550 h-80 bg-center bg-cover" style="background-image: url(assets/Group-397.png)">
        <div class="w-full mx-auto flex flex-wrap overflow-hidden flex-col justify-between h-full">
            <div class="bg-transparent py-4">
                <div class="max-w-full mx-auto">
                    <div class="flex flex-wrap overflow-hidden justify-around items-center">
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
            <h3 class="text-white py-4 text-center text-5xl uppercase" >{{$event->wall_location_msg}}</h3>
        </div>
    </section>

    <section class="p-5 bg-black w-full">
        <div class="masonry md:cols--3 lg:cols--5">
@if(count($posts)>1)
    @foreach ($posts as $post)
        <a href="{{$post['permalink_url']}}">
            <div class="masonry-item">
                <div class="masonry-content">
                    <div class="relative">
                        <img class=" rounded-lg" src="{{$post['full_picture']}}" alt="Dummy Image">
                        <img src="{{asset('assets/fb.png')}}" class=" absolute w-8 h-8 bottom-4 left-4" alt="">
                    </div>
                    <div class="p-4">
                        <p>
                            {{$post['message']}}
                        </p>
                    </div>
                    <div class="flex flex-wrap overflow-hidden justify-between items-center p-4">
                        <div class="flex flex-wrap overflow-hidden justify-between items-center">
                            <img src="{{asset('user/profile/'. App\Models\User::where('id','=',$event->created_by)->get()[0]->image)}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                            <div class="pl-2">
                                <p class="font-medium">{{$post['from']->name}}</p>
                                <p class="text-xs">{{App\Models\User::where('id','=',$event->created_by)->get()[0]->account_type}}</p>
                            </div>
                        </div>
                        <div>
                            <i class="far fa-clock"></i><span class="text-sm pl-2">{{ date('h:i A', strtotime($post['created_time']))}}</span>
                        </div>
                    </div>
                </div>
            </div></a>
    @endforeach
@endif

        </div>
    </section>

    <section class="absolute w-full h-screen top-0 left-0 bg-black bg-opacity-80"
        x-show="ad"
        @click.away="ad = !ad"
        x-transition:enter="transition transform origin-top-left ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition transform origin-top-left ease-out duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75">
        <div class="h-full w-full flex flex-wrap justify-center items-center">
            <div class="w-9/12 mx-auto relative rounded-xl">
                <img src="{{asset('assets/Group 396.png')}}" class="mx-auto rounded-xl" alt="">
                <p class="absolute left-5 top-4"><i class="far fa-clock"></i><span class="text-sm pl-2">This Ad will close in 12 seconds.</span></p>
                <p class="absolute right-5 top-4"><i class="fas fa-times cursor-pointer" @click=" ad = !ad "></i></p>
            </div>
        </div>
    </section>

    <section class="absolute w-full h-screen top-0 left-0 bg-black bg-opacity-80 flex flex-wrap items-center justify-center"
        x-show="card"
        @click.away="card = !card"
        x-transition:enter="transition transform origin-top-left ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition transform origin-top-left ease-out duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75">
        <div class="w-1/2 mx-auto flex flex-wrap overflow-hidden rounded-xl">
            <div class=" overflow-hidden w-1/2">
                <img src="{{asset('assets/Maroon-5-2018-web-optimised-1000.jpg')}}" class=" w-full h-full object-cover" alt="">
            </div>
            <div class=" overflow-hidden w-1/2 bg-white p-5 relative">
                <p class="absolute right-5 top-4"><i class="fas fa-times cursor-pointer" @click=" card = !card "></i></p>
                <div class="flex flex-wrap overflow-hidden justify-start items-center">
                    <img src="{{asset('assets/sample-profile.png')}}" class="w-10 h-10 rounded-full object-contain bg-white avatar" alt="">
                    <div class="pl-2">
                        <p class="font-medium">Account Username</p>
                        <p class="text-xs">Premium Account</p>
                    </div>
                </div>
                <p class="py-5">
                    Weekend sorted 🥳 Take the family out for a day of movie madness with $8* TICKETS on select family films! Book your tickets now 👉 bit.ly/SaveFamilyTix
                    <br>
                    *$1.50 online booking fees apply. Must be a Cinebuzz member to access special price. Excludes premium seating options.
                </p>
                <p class="tags">
                    #event #wedding #party #events #eventplanner #music #love #photography #birthday #dj #art #eventorganizer #weddingplanner #instagood #like #fun #fashion #design #instagram #eventplanning #festival
                </p>
                <div class="flex flex-wrap overflow-hidden justify-between items-center pt-5">
                    <div class="flex flex-wrap overflow-hidden justify-start items-center">
                        <img src="{{asset('assets/fb.png')}}" class="w-8 h-8" alt="">
                        <div class="pl-2">
                            <p class="">Post From Facebook</p>
                        </div>
                    </div>
                    <div>
                        <i class="far fa-clock"></i><span class="text-sm pl-2">Just Now</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
