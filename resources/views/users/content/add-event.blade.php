@extends('visitor.layout.visitorLayout')
@section('title','Add Your Event')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){

    $("#select-img").click(function(e) {
     $("#imageUpload").click();
 });

function fasterPreview1( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#coverImage').attr('src',
             window.URL.createObjectURL(uploader.files[0]) );
             document.getElementById('uploadAvatarBtn').style.display = 'inline';
    }
}

$("#imageUpload").change(function(){
    fasterPreview1( this );
});


$("#select-bgimg").click(function(e) {
     $("#wall_image").click();
 });

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#wall_bg').attr('src',
             window.URL.createObjectURL(uploader.files[0]) );
             document.getElementById('uploadAvatarBtn').style.display = 'inline';
    }
}

$("#wall_image").change(function(){
    fasterPreview( this );
});

$("#m_dap_wall").on('keyup', function(e) {

var wordss = 0;

if ((this.value.match(/\S+/g)) != null) {
  wordss = this.value.match(/\S+/g).length;
}

if (wordss > 20) {
    e.preventDefault();
  // Split the string on first 200 words and rejoin on spaces
  var trimmed = $(this).val().split(/\s+/, 20).join(" ");
  // Add a space at the end to make sure more typing creates new words
  $(this).val(trimmed + " ");

}
else {
  $('#w_counter').text(wordss);
  //$('#word_left').text(200-words);
}
});

$("#e_descrip").on('keyup', function(e) {

var words = 0;

if ((this.value.match(/\S+/g)) != null) {
  words = this.value.match(/\S+/g).length;
}

if (words > 20) {
    e.preventDefault();
  // Split the string on first 200 words and rejoin on spaces
  var trimmed = $(this).val().split(/\s+/, 20).join(" ");
  // Add a space at the end to make sure more typing creates new words
  $(this).val(trimmed + " ");

}
else {
  $('#display_count').text(words);
  //$('#word_left').text(200-words);
}
});



    });
</script>
@endsection
@section('content')
@include('users.inc.nav')
<main>
    <section class="page-title bg-white py-5 shadow-md">
        <h2 class="uppercase text-center text-xl font-medium">Add Your Event</h2>
    </section>

    <section class="py-10 max-w-5xl mx-auto">
        <form action="{{route('add.event')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Event Name <span class="text-red-600">*</span>
                                <input type="text" name="ename" class="input-field" placeholder="Write your venue name" value="{{old('ename')}}">
                            </label>
                            @error('ename')<small class="text-red-600">Please enter the Event name</small> @enderror
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Venue <span class="text-red-600">*</span>

                                <select name="location" id="location" class="input-field">
                                    @foreach ($locations as $location)

                                    <option value="{{$location}}" >{{$location}}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    <div class="ml-4">
                        @error('location') <small class="text-red-600">Please enter the location</small>@enderror
                    </div>
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Add Cover Image <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}" id="coverImage" class="object-cover w-full rounded-md" alt="" >
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" alt="">
                                        <small class="text-gray-400 pt-2">Drop an image to Upload</small>
                                        <p id="select-img" class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</p>
                                        <input id="imageUpload" type="file" name="cover_img" placeholder="Photo"  capture hidden>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="ml-4">
                        @error('cover_img') <small class="text-red-600">Please add cover image</small>@enderror
                        </div>
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Event Description <span class="text-red-600">*</span>
                                <textarea name="e_descrip" id="e_descrip" rows="3" placeholder="Write briefly about your Event" class="input-field">{{old('e_descrip')}}</textarea>
                            </label>
                            <small name="display_count" id="display_count" class="float-right px-3" >0/120</small>
                            @error('e_descrip') <small class="text-red-600">Please write some description about event</small>@enderror
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="hashtag">
                                Hashtag(s) <span class="text-red-600">*</span>
                                <input type="text" name="h_tag" placeholder="#party  #partytime" class="input-field"/>

                            </label>
                            @error('h_tag') <small class="text-red-600">Please add some hashtags</small>@enderror
                            <p class="inline-block pt-1">Approve all <span class="text-blue-550">#hashtags</span> posts from your DapSocially Location Wall</p>
                            <div class="relative inline-block w-10 mx-2 align-middle select-none pt-1">
                                <input type="checkbox" name="app_htag" id="Blue" class="checked:bg-white outline-none focus:outline-none right-5 checked:right-0 duration-200 ease-in absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label for="Blue" class="block overflow-hidden h-5 rounded-full bg-blue-550 cursor-pointer">
                                    </label>
                            </div>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <p class="">Where would you like to collect social media hashtags from?</p>
                            <ul class="list-none pt-3">
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb1" name="h_tags[]" value="facebook" checked >
                                    <label for="cb1" class="cb-label">
                                        <img src="{{asset('assets/fb.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb2" name="h_tags[]" value="instagram">
                                    <label for="cb2" class="cb-label">
                                        <img src="{{asset('assets/Insta.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb3" name="h_tags[]" value="twitter">
                                    <label for="cb3" class="cb-label">
                                        <img src="{{asset('assets/twitter.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb4" name="h_tags[]" value="tiktok">
                                    <label for="cb4" class="cb-label">
                                        <img src="{{asset('assets/tiktok.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                            </ul>
                            @error('h_tags') <small class="text-red-600">Please select altleast one scoial media account</small>@enderror
                        </div>

                        <div class="w-full overflow-hidden md:mt-2 md:px-2 lg:mt-3 lg:px-3 xl:mt-3 xl:px-3">
                            <p>Collect Posts from your Profile Pages? <span class="text-red-600">*</span></p>
                        </div>
                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="fb" name="fb" checked>
                                <label for="fb" class="cb--label">
                                    <img src="{{asset('assets/fb.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*" name="fbi">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="insta" name="insta">
                                <label for="insta" class="cb--label">
                                    <img src="{{asset('assets/Insta.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*" name="instap">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="twitter" name="twitter">
                                <label for="twitter" class="cb--label">
                                    <img src="{{asset('assets/twitter.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*" name="twitterp">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="tiktok" name="tiktok">
                                <label for="tiktok" class="cb--label">
                                    <img src="{{asset('assets/tiktok.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*" name="tiktokp">
                        </div>
                        <div class="ml-4">
                            @error('p_fb') <small class="text-red-600">Please add your public page id or post</small>@enderror
                            </div>
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Message for Dapsocially Locations Wall <span class="text-red-600">*</span>
                                <textarea name="m_dap_wall" id="m_dap_wall" rows="3" placeholder="Write a Message for your Dapsocially Locations Wall*" class="input-field">{{old('m_dap_wall')}}</textarea>
                            </label>
                            <small class="float-right px-3" id="w_counter" >0/20</small>
                            @error('m_dap_wall') <small class="text-red-600">Please write a message for dapsocially wall</small>@enderror
                        </div>
                    <div class="w-full">
                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Select Background image for your Social Wall <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}" id="wall_bg" class="object-cover w-full rounded-md" alt="">
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" alt="">
                                        <p id="select-bgimg" class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</p>
                                        <input id="wall_image" type="file" name="wall_bg_img" placeholder="Photo"  capture hidden>
                                    </div>
                                </div>
                            </label>

                        </div>
                    <div class="ml-4">
                        @error('wall_bg_img') <small class="text-red-600">Upload an image for social wall background</small>@enderror
                    </div>
                    </div>
                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Starts at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" name="s_date" class="input---field rounded-r-none rounded-l-md" value="{{old('s_date')}}">
                                    <input type="time" name="s_time" class="input---field rounded-l-none rounded-r-md" value="{{old('s_time')}}">
                                </div>
                                <div class="flex">
                                @error('s_date') <small class="text-red-600">Enter start date  properly </small>@enderror
                                <div class="ml-16">  @error('s_time') <small class="text-red-600">Enter start  time properly </small>@enderror</div>
                                  </div>

                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Ends at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" name="e_date" class="input---field rounded-r-none rounded-l-md" value="{{old('e_date')}}">
                                    <input type="time" name="e_time" class="input---field rounded-l-none rounded-r-md" value="{{old('e_time')}}">
                                </div>
                            </label>
                            <div class="flex">
                            @error('e_date') <small class="text-red-600">Enter end date properly </small>@enderror
                            <div class="ml-16">  @error('e_time') <small class="text-red-600">Enter end time properly </small>@enderror</div>
                            </div>
                        </div>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3"
                        x-data="{isPkg:'Free', message:''}">
                            <h3 class="text-xl font-medium text-center uppercase mt-5">Pricing</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 py-5 ">
                                @foreach ($P_plans as $plans)

                                {{-- @if ($plans->price==0)
                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-blue-450" >
                                    <p class="uppercase text-lg text-center font-medium text-white">{{$plans->name}}</p>
                                    <img src="{{asset('assets/Group 389.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-white my-3">
                                    <p class="text-white text-center">
                                        {{$plans->description}}
                                    </p>
                                    <p class="text-2xl text-white text-center uppercase my-3 font-medium">Free</p>
                                    <p  class="bg-blue-550 text-white px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-white hover:border-white hover:text-blue-550">Choose</p>
                                </div>

                                @else --}}
                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white"
                                    :class="{'bg-blue-450': isPkg === {{$plans->id}} }">
                                    <p class="uppercase text-lg text-center font-medium"
                                        :class="{'text-white': isPkg === {{$plans->id}} }">{{$plans->name}}</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3"
                                    :class="{'border-white': isPkg === {{$plans->id}} }">
                                    <p class="text-center"
                                        :class="{'text-white': isPkg === {{$plans->id}} }">
                                        {{$plans->description}}
                                    </p>
                                    @if ($plans->price == 0)
                                        <p class="text-2xl text-center uppercase my-3 font-medium"
                                            :class="{'text-white': isPkg === {{ $plans->id }} }">Free</p>
                                    @else
                                        <p class="text-2xl text-center uppercase my-3 font-medium"
                                            :class="{'text-white': isPkg === {{ $plans->id }} }">${{ $plans->price }}
                                        </p>
                                    @endif
                                    <p  class="bg-transparent text-blue-550 px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:text-white hover:bg-blue-550 "
                                    :class="{'hover:border-white hover:text-white bg-white': isPkg === {{$plans->id}} }" @click="isPkg = {{$plans->id}}, message='{{$plans->id}}' ">Choose</p>

                                </div>
                                {{-- @endif --}}
                                @endforeach
                                <input type="text" name="plan" id="plan" x-model="message" hidden>
                                @error('plan') <small class="text-red-600 ml-30">Please select one package</small>@enderror
                                {{-- <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white" x-show="price11">
                                    <p class="uppercase text-lg text-center font-medium">Free</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Collect up to 20 Posts for an Hour
                                        for your Event
                                    </p>
                                    <p class="text-2xl text-center uppercase my-3 font-medium">Free</p>
                                    <p  class="bg-transparent text-blue-550 px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white" @click=" price11 = false, price1 = true, price2 = true, price22=false ">Choose</p>
                                </div>
                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-blue-450" x-show="price22" >
                                    <p class="uppercase text-lg text-center font-medium text-white">Diamond</p>
                                    <img src="{{asset('assets/Group 389.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-white my-3">
                                    <p class="text-white text-center">
                                        Collect Unlimited Posts for 1 Month
                                        for your Event.
                                    </p>
                                    <p class="text-2xl text-white text-center uppercase my-3 font-medium">$99</p>
                                    <p  class="bg-blue-550 text-white px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-white hover:border-white hover:text-blue-550" @click=" price22 = true, price2=false, price1=false, price11=true ">Choose</p>
                                </div>--}}
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
