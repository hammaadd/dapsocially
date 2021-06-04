@extends('visitor.layout.visitorLayout')
@section('title','Event Time & Pricing')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">Event Time & Pricing</h2>
    </section>

    <section class="py-10 max-w-5xl mx-auto">
        <form action="#">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Starts at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" class="input---field rounded-r-none rounded-l-md">
                                    <input type="time" class="input---field rounded-l-none rounded-r-md">
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Ends at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" class="input---field rounded-r-none rounded-l-md">
                                    <input type="time" class="input---field rounded-l-none rounded-r-md">
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <h3 class="text-xl font-medium text-center uppercase mt-5">Pricing</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 py-5">
                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-blue-450">
                                    <p class="uppercase text-lg text-center font-medium text-white">Standard</p>
                                    <img src="{{asset('assets/Group 389.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-white my-3">
                                    <p class="text-white text-center">
                                        Collect up to 20 Posts for an Hour for your Event
                                    </p>
                                    <p class="text-2xl text-white text-center uppercase my-3 font-medium">Free</p>
                                    <a href="#" class="bg-blue-550 text-white px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-white hover:border-white hover:text-blue-550">Choose</a>
                                </div>

                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                                    <p class="uppercase text-lg text-center font-medium">Diamond</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Collect Unlimited Posts for 1 Month for your Event.
                                    </p>
                                    <p class="text-2xl text-center uppercase my-3 font-medium">$99</p>
                                    <a href="#" class="bg-transparent text-blue-550 px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white">Choose</a>
                                </div>

                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                                    <p class="uppercase text-lg text-center font-medium">Diamond</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Collect Unlimited Posts for 1 Year for your Event.
                                    </p>
                                    <p class="text-2xl text-center uppercase my-3 font-medium">$99</p>
                                    <a href="#" class="bg-transparent text-blue-550 px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white">Choose</a>
                                </div>
                            </div>
                        </div>



                        <div class="w-full text-center py-1">
                            <a href="#" class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Cancel</a>
                            <button type="submit" class="px-5 py-1.5 bg-blue-550 text-white uppercase rounded-3xl border-2 border-blue-550 hover:bg-transparent hover:text-blue-550 mx-3">Start</button>
                        </div>

                      </div>
                </div>
            </div>
        </form>
    </section>
</main>
@include('users.inc.footer')
@endsection
