@extends('visitor.layout.visitorLayout')
@section('title','Profile')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">User Profile</h2>
    </section>

    <section class="py-10 max-w-5xl mx-auto">
        <h3 class="text-lg font-medium">Account Details</h3>
        <form action="#">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-2/3">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="name">
                                Name
                                <input type="text" class="input-field" placeholder="Stephen K. Colins">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="email">
                                Email
                                <input type="email" class="input-field" placeholder="stephencolins@dayrap.com">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="dob">
                                Date of Birth
                                <input type="date" class="input-field" placeholder="Stephen K. Colins">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="gender">
                                Gender
                                <select name="" id="" class="input-field">
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Not Specified</option>
                                </select>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <button type="submit" class="px-5 py-1.5 bg-blue-550 text-white rounded-3xl border-2 border-blue-550 hover:bg-transparent hover:text-blue-550">Save Changes</button>
                        </div>

                      </div>
                </div>
                <div class="w-full md:w-1/3">
                    <div class="flex flex-wrap overflow-hidden items-center flex-col">
                        <div class="w-36 h-36 relative rounded-full overflow-hidden">
                            <img src="{{asset('assets/sample-profile.png')}}" class="profile-img w-36 h-36 rounded-full object-cover" alt="">
                            <div class="absolute text-white bg-black bg-opacity-50 text-center w-full h-9 bottom-0">
                                <i id="select-img" class="fas fa-camera text-xl cursor-pointer pt-1.5"></i>
                            </div>
                        </div>
                        <div class="text-center pt-2">
                            <p class="text-xl font-medium">Stephen K. Collins</p>
                            <small>Premium User</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="#" class="pt-3">
            <h3 class="text-lg font-medium">Security</h3>
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-2/3">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="current-pass">
                                Current Password
                                <input type="password" class="input-field" placeholder="Current Password">
                            </label>
                            <small class="text-red-600">*Password must be 8 characters long.</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="password">
                                New Password
                                <input type="password" class="input-field" placeholder="New Password">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="confirm-pass">
                                Confirm New Password
                                <input type="password" class="input-field" placeholder="Confirm Password">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <button type="submit" class="px-5 py-1.5 bg-blue-550 text-white rounded-3xl border-2 border-blue-550 hover:bg-transparent hover:text-blue-550">Change Password</button>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3"></div>
            </div>
        </form>

        <form action="#" class="pt-3">
            <h3 class="text-lg font-medium">Connected Social Media Accounts</h3>
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
        </form>
    </section>
</main>
@include('users.inc.footer')
@endsection
