@extends('visitor.layout.visitorLayout')
@section('title','Profile')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){

    $("#select-img").click(function(e) {
     $("#imageUpload").click();
 });

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#profileImage').attr('src',
             window.URL.createObjectURL(uploader.files[0]) );
             document.getElementById('uploadAvatarBtn').style.display = 'inline';
    }
}

$("#imageUpload").change(function(){
    fasterPreview( this );
});
});
</script>

@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">User Profile</h2>
    </section>
    <nav class="p-5">
        <ol class="list-reset flex text-grey-dark">
          <li><a href="{{route('homepage')}}" class="text-blue-550 font-bold">Home</a></li>
          <li><span class="mx-2">/</span></li>
          <li>My Profile</li>
        </ol>
      </nav>
    <section class="px-5 py-5 lg:py-10 max-w-5xl mx-auto">
        <h3 class="text-lg font-medium">Account Details</h3>
        <form action="{{route('user.update.profile')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap overflow-hidden flex-col-reverse md:flex-row pt-5 md:pt-0">
                <div class="w-full md:w-2/3">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="name">
                                Name
                                <input type="text" id="uname" name="uname" class="input-field" placeholder="Your name" value="{{Auth::user()->name}}">
                            </label>
                            <small class="text-red-600">@error('uname'){{$message}}@enderror</small>

                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="email">
                                Email
                                <input type="email" id="mail" name="mail" class="input-field" placeholder="stephencolins@dayrap.com" value="{{Auth::user()->email}}">
                            </label>
                            <small class="text-red-600">@error('mail'){{$message}}@enderror</small>

                        </div>


                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="dob">
                                Date of Birth
                                <input type="date" id="dob" name="dob" class="input-field" placeholder="Stephen K. Colins" value="{{Auth::user()->dob}}">
                            </label>
                            <small class="text-red-600">@error('dob'){{$message}}@enderror</small>


                        </div>


                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="gender">
                                Gender
                                <select name="gender" id="gender" class="input-field">

                                    @if (Auth::user()->gender=='Male')
                                    <option value="Male" selected>Male</option>
                                    @else
                                    <option value="Male">Male</option>
                                    @endif
                                    @if (Auth::user()->gender=='Female')
                                    <option value="Female" selected>Female</option>
                                    @else
                                    <option value="Female">Female</option>
                                    @endif



                                </select>
                            </label>
                        </div>


                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0 text-center md:text-left">
                            <button type="submit" class="px-5 py-1.5 bg-blue-550 text-white rounded-3xl border-2 border-blue-550 hover:bg-transparent hover:text-blue-550 focus:outline-none">Save Changes</button>
                        </div>

                      </div>
                </div>
                <div class="w-full md:w-1/3">
                    <div class="flex flex-wrap overflow-hidden items-center flex-col">

                        <div class="w-28 h-28 md:w-36 md:h-36 relative rounded-full overflow-hidden">
                            <img src="{{asset('user/profile/'.Auth::user()->image)}}" id="profileImage" class="profile-img w-28 h-28 md:w-36 md:h-36 rounded-full object-cover" alt="Profile">
                            <div class="absolute text-white bg-black bg-opacity-50 text-center w-full h-9 bottom-0">
                                <i  id="select-img" name="img" class="fas fa-camera text-xl cursor-pointer pt-1.5"></i>
                                <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo"  capture hidden>
                            </div>

                        </div>
                        <div class="text-center pt-2">
                            <p class="text-xl font-medium">{{Auth::user()->name}}</p>
                            <small>{{Auth::user()->account_type}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('user.update.password')}}" class="pt-3" method="POST">
            @csrf
            <h3 class="text-lg font-medium">Security</h3>
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full md:w-2/3">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3 pt-3 md:pt-0">
                            <label for="current-pass">
                                Current Password
                                <input type="password" class="input-field" placeholder="Current Password" name="currentpassword" id="currentpassword">

                            </label>
                            <small class="text-red-600">@error('currentpassword'){{$message}}@enderror</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="password">
                                New Password
                                <input type="password" class="input-field" placeholder="New Password" name="newpassword" id="newpassword">

                            </label>
                            <small class="text-red-600">@error('newpassword'){{$message}}@enderror</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0">
                            <label for="confirm-pass">
                                Confirm New Password
                                <input type="password" class="input-field" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword">

                            </label>
                            <small class="text-red-600">@error('confirmpassword'){{$message}}@enderror</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2 pt-3 md:pt-0 text-center md:text-left">
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
                @if (count($attach_accounts)<1)
                <p>No Social Media Accounts Connected</p>
                @else


                @foreach ($attach_accounts as $attach_account )
                @if ($attach_account->verified_acc=='facebook')
                <li class="inline-block mx-2">
                    <input type="checkbox" class="cb-input hidden" id="cb1" name="h_tags[]" value="facebook" checked >
                    <label for="cb1" class="cb-label">
                        <img src="{{asset('assets/fb.png')}}" class="w-10 h-10 mx-auto" alt="">
                        <p class="text-add pt-4 text-sm">Add</p>
                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                    </label>
                </li>
                @endif
                @if ($attach_account->verified_acc=='instagram')
                <li class="inline-block mx-2">
                    <input type="checkbox" class="cb-input hidden" id="cb2" name="h_tags[]" value="instagram" checked>
                    <label for="cb2" class="cb-label">
                        <img src="{{asset('assets/Insta.png')}}" class="w-10 h-10 mx-auto" alt="">
                        <p class="text-add pt-4 text-sm">Add</p>
                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                    </label>
                </li>
                @endif
                @if ($attach_account->verified_acc=='twitter')
                <li class="inline-block mx-2">
                    <input type="checkbox" class="cb-input hidden" id="cb3" name="h_tags[]" value="twitter" checked>
                    <label for="cb3" class="cb-label">
                        <img src="{{asset('assets/twitter.png')}}" class="w-10 h-10 mx-auto" alt="">
                        <p class="text-add pt-4 text-sm">Add</p>
                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                    </label>
                </li>
                @endif
                @if ($attach_account->verified_acc=='tiktok')
                <li class="inline-block mx-2">
                    <input type="checkbox" class="cb-input hidden" id="cb4" name="h_tags[]" value="tiktok" checked>
                    <label for="cb4" class="cb-label">
                        <img src="{{asset('assets/tiktok.png')}}" class="w-10 h-10 mx-auto" alt="">
                        <p class="text-add pt-4 text-sm">Add</p>
                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                    </label>
                </li>
                @endif
                @endforeach
                @endif
            </ul>
        </form>
    </section>
</main>
@include('users.inc.footer')

@endsection
