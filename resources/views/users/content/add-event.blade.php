@extends('visitor.layout.visitorLayout')
@section('title','Add Your Event')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">Add Your Event</h2>
    </section>

    <section class="py-10 max-w-5xl mx-auto">
        <form action="#">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Event Name <span class="text-red-600">*</span>
                                <input type="text" class="input-field" placeholder="Write your venue name">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Venue <span class="text-red-600">*</span>
                                <select name="" id="" class="input-field">
                                    <option value="">Select Venue</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                    <option value="">Option 3</option>
                                </select>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Add Cover Image <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}" class="object-cover w-full rounded-md" alt="">
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" alt="">
                                        <small class="text-gray-400 pt-2">Drop an image to Upload</small>
                                        <button class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</button>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Event Description <span class="text-red-600">*</span>
                                <textarea name="" id="" rows="3" placeholder="Write briefly about your Event" class="input-field"></textarea>
                            </label>
                            <small class="float-right px-3" >0/120</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="hashtag">
                                Hashtag(s) <span class="text-red-600">*</span>
                                <input type="text" placeholder="#party  #partytime" class="input-field"/>
                            </label>
                            <p class="inline-block pt-1">Approve all <span class="text-blue-550">#hashtags</span> posts from your DapSocially Location Wall</p>
                            <div class="relative inline-block w-10 mx-2 align-middle select-none pt-1">
                                <input type="checkbox" name="toggle" id="Blue" class="checked:bg-white outline-none focus:outline-none right-5 checked:right-0 duration-200 ease-in absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label for="Blue" class="block overflow-hidden h-5 rounded-full bg-blue-550 cursor-pointer">
                                    </label>
                            </div>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <p class="">Where would you like to collect social media hashtags from?</p>
                            <ul class="list-none pt-3">
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb1" checked>
                                    <label for="cb1" class="cb-label">
                                        <img src="{{asset('assets/fb.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb2">
                                    <label for="cb2" class="cb-label">
                                        <img src="{{asset('assets/Insta.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb3">
                                    <label for="cb3" class="cb-label">
                                        <img src="{{asset('assets/twitter.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb4">
                                    <label for="cb4" class="cb-label">
                                        <img src="{{asset('assets/tiktok.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div class="w-full overflow-hidden md:mt-2 md:px-2 lg:mt-3 lg:px-3 xl:mt-3 xl:px-3">
                            <p>Collect Posts from your Profile Pages? <span class="text-red-600">*</span></p>
                        </div>
                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="fb" checked>
                                <label for="fb" class="cb--label">
                                    <img src="{{asset('assets/fb.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="insta">
                                <label for="insta" class="cb--label">
                                    <img src="{{asset('assets/Insta.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="twitter">
                                <label for="twitter" class="cb--label">
                                    <img src="{{asset('assets/twitter.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="tiktok">
                                <label for="tiktok" class="cb--label">
                                    <img src="{{asset('assets/tiktok.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Message for Dapsocially Locations Wall <span class="text-red-600">*</span>
                                <textarea name="" id="" rows="3" placeholder="Write a Message for your Dapsocially Locations Wall*" class="input-field"></textarea>
                            </label>
                            <small class="float-right px-3" >0/20</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Select Background image for your Social Wall <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}" class="object-cover w-full rounded-md" alt="">
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" alt="">
                                        <small class="text-gray-400 pt-2">Drop an image to Upload</small>
                                        <button class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</button>
                                    </div>
                                </div>
                            </label>
                        </div>

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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 py-5 w-full md:w-4/5 lg:w-3/5 mx-auto">
                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-blue-450">
                                    <p class="uppercase text-lg text-center font-medium text-white">Standard</p>
                                    <img src="{{asset('assets/Group 389.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-white my-3">
                                    <p class="text-white text-center">
                                        Collect up to 20 Posts for an Hour
                                        for your Event
                                    </p>
                                    <p class="text-2xl text-white text-center uppercase my-3 font-medium">Free</p>
                                    <a href="#" class="bg-blue-550 text-white px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-white hover:border-white hover:text-blue-550">Choose</a>
                                </div>

                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                                    <p class="uppercase text-lg text-center font-medium">Diamond</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Collect Unlimited Posts for 1 Month
                                        for your Event.
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
