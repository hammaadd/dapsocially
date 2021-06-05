@extends('visitor.layout.visitorLayout')
@section('title','Add Your Venue')
@section('headerExtra')
<link rel="stylesheet" href="{{asset('css/checkboxes.css')}}">
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdV4ukitqwrOQ08JZwG7AeLK-6b7cJRhs&callback=initAutocomplete&libraries=places&v=weekly"
        defer></script>
    <script>
        let autocomplete;
        let address1Field;
        let address2Field;
        let postalField;

        function initAutocomplete() {
            address1Field = document.querySelector("#loc_address");
            // Create the autocomplete object, restricting the search predictions to
            // addresses in the US and Canada.
            autocomplete = new google.maps.places.Autocomplete(address1Field, {

                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            address1Field.focus();
            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.

            const place = autocomplete.getPlace();
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            let address1 = "";
            for (const component of place.address_components) {
                const componentType = component.types[0];

                switch (componentType) {
                    case "street_number": {
                        address1 = `${component.long_name} ${address1}`;
                        break;
                    }

                    case "route": {
                        address1 += component.short_name;
                        break;
                    }

                    case "locality":
                        document.querySelector("#locality").value = component.long_name;
                        break;

                    case "administrative_area_level_1": {
                        document.querySelector("#state").value = component.short_name;
                        break;
                    }
                    case "country":
                        document.querySelector("#country").value = component.long_name;
                        break;
                }
            }
            address1Field.value = address1;
        }
        </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){
       
    $("#select-img").click(function(e) {
     $("#imageUpload").click();
 });

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
          $('#coverImage').attr('src',
             window.URL.createObjectURL(uploader.files[0]) );
             document.getElementById('uploadAvatarBtn').style.display = 'inline';
    }
}

$("#imageUpload").change(function(){
    fasterPreview( this );
});

  
$("#select-bg-img").click(function(e) {
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


$("#e_descrip").on('keyup', function(e) {

    var words = 0;

    if ((this.value.match(/\S+/g)) != null) {
      words = this.value.match(/\S+/g).length;
    }

    if (words > 20) {
        e.preventDefault();
      // Split the string on first 200 words and rejoin on spaces
      var trimmed = $(this).val().split(/\s+/, 200).join(" ");
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
        <h2 class="uppercase text-center text-xl font-medium">Add Your Venue</h2>
    </section>

    <section class="py-10 max-w-5xl mx-auto">
        <form action="#">
            <div class="flex flex-wrap overflow-hidden">
                <div class="w-full">
                    <div class="flex flex-wrap overflow-hidden md:-mx-2 lg:-mx-3 xl:-mx-3">

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Venue Name <span class="text-red-600">*</span>
                                <input type="text" id="vname" id="vname" class="input-field" placeholder="Write your venue name">
                            </label>
                            <small class="text-red-600">@error('vname'){{$message}}@enderror</small>

                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Location <span class="text-red-600">*</span>
                                <input type="text"  id="loc_address" name="loc_address" class="input-field" placeholder="California" required autocomplete="off">
                            </label>
                            <small class="text-red-600">@error('uname'){{$message}}@enderror</small>

                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/3 lg:my-3 lg:px-3 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
                            <label for="city">
                                City
                                <input type="text" id="locality" name="locality" class="input-field" placeholder="City">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/3 lg:my-3 lg:px-3 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
                            <label for="state">
                                State
                                <input type="text" id="state" name="state" class="input-field" placeholder="State">
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/3 lg:my-3 lg:px-3 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
                            <label for="country">
                                Country
                                <input type="text" id="country" name="country" class="input-field" placeholder="Country">
                            </label>
                        </div>
                        <input type="text" name="latitude" id="latitude" class="form-control" hidden>
                        <input type="text" name="longitude" id="longitude" class="form-control" hidden>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Add Cover Image <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}"  class="object-cover w-full rounded-md" alt="">
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" id="coverImage" alt="">
                                        <small class="text-gray-400 pt-2">Drop an image to Upload</small>
                                        <p id="select-img" class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</p>
                                        <input id="imageUpload" type="file" name="cover_img" placeholder="Photo"  capture hidden>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Event Description <span class="text-red-600">*</span>
                                <textarea name="e_descrip" id="e_descrip" rows="3" placeholder="Write briefly about your Event" class="input-field"></textarea>
                            </label>
                            <small id="display_count" name="display_count" class="float-right px-3" >0/20</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="hashtag">
                                Hashtag(s) <span class="text-red-600">*</span>
                                <input type="text" name="h_tag" id="h_tag" placeholder="#party  #partytime" class="input-field"/>
                            </label>
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
                                    <input type="checkbox" class="cb-input hidden" id="cb1" name="h_fb" checked>
                                    <label for="cb1" class="cb-label">
                                        <img src="{{asset('assets/fb.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb2" name="h_inst">
                                    <label for="cb2" class="cb-label">
                                        <img src="{{asset('assets/Insta.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb3" name="h_tw">
                                    <label for="cb3" class="cb-label">
                                        <img src="{{asset('assets/twitter.png')}}" class="w-10 h-10 mx-auto" alt="">
                                        <p class="text-add pt-4 text-sm">Add</p>
                                        <p class="text-remove pt-4 text-sm hidden">Remove</p>
                                    </label>
                                </li>
                                <li class="inline-block mx-2">
                                    <input type="checkbox" class="cb-input hidden" id="cb4" name="h_t">
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
                                <input type="checkbox" class="cb-input hidden" id="fb" name="fb" checked>
                                <label for="fb" class="cb--label">
                                    <img src="{{asset('assets/fb.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" name="p_fb" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="insta" name="insta">
                                <label for="insta" class="cb--label">
                                    <img src="{{asset('assets/Insta.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" name="p_inst" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="twitter" name="twitter">
                                <label for="twitter" class="cb--label">
                                    <img src="{{asset('assets/twitter.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" name="p_tw" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:mb-2 md:px-2 md:w-1/2 lg:mb-3 lg:px-3 lg:w-1/2 xl:mb-3 xl:px-3 xl:w-1/2 flex py-1.5">
                            <div class="inline-block mr-3">
                                <input type="checkbox" class="cb-input hidden" id="tiktok" name="tiktok">
                                <label for="tiktok" class="cb--label">
                                    <img src="{{asset('assets/tiktok.png')}}" class="w-6 h-6 mx-auto" alt="">
                                </label>
                            </div>
                            <input type="text" name="p_tik" class="input--field w--52 min-h-40" placeholder="Enter your Public Page id or Username*">
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="description">
                                Message for Dapsocially Locations Wall <span class="text-red-600">*</span>
                                <textarea name="m_dap_wall" id="m_dap_wall" rows="3" placeholder="Write a Message for your Dapsocially Locations Wall*" class="input-field"></textarea>
                            </label>
                            <small class="float-right px-3" >0/20</small>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                            <label for="cover">
                                Select Background image for your Social Wall <span class="text-red-600">*</span>
                                <div class="w-full h-60 relative border-gray-200 border bg-gray-200 rounded-md mt-1">
                                    <img src="{{asset('assets/Rectangle 119.png')}}" class="object-cover w-full rounded-md" alt="">
                                    <div class="flex flex-wrap overflow-hidden items-center justify-center flex-col absolute top-0 left-0 right-0 h-full">
                                        <img src="{{asset('assets/icons8_image_file_add.png')}}" id="wall_bg" alt="">
                                        <small class="text-gray-400 pt-2">Drop an image to Upload</small>
                                        <p id="select-bg-img" class="text-gray-400 border border-gray-400 px-3 py-1.5 mt-2 rounded-3xl bg-transparent hover:bg-gray-400 hover:text-white">Select Image</p>
                                        <input id="wall_image" type="file" name="wall_bg_img" placeholder="Photo"  capture hidden>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="vname">
                                Starts at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" id="s_date" name="s_date" class="input---field rounded-r-none rounded-l-md">
                                    <input type="time" id="s_time" name="s_time" class="input---field rounded-l-none rounded-r-md">
                                </div>
                            </label>
                        </div>

                        <div class="w-full overflow-hidden md:my-2 md:px-2 md:w-1/2 lg:my-3 lg:px-3 lg:w-1/2 xl:my-3 xl:px-3 xl:w-1/2">
                            <label for="location">
                                Ends at <span class="text-red-600">*</span>
                                <div class="flex">
                                    <input type="date" id="e_date" name="e_date" class="input---field rounded-r-none rounded-l-md">
                                    <input type="time" id="e_time" name="e_time" class="input---field rounded-l-none rounded-r-md">
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
                                        Unlimited Posts Collections from
                                        Facebook, Instagram, Twitter and Tiktok.
                                        Contains Ads.
                                    </p>
                                    <p class="text-2xl text-white text-center uppercase my-3 font-medium">Free</p>
                                    <a href="#" class="bg-blue-550 text-white px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-white hover:border-white hover:text-blue-550">Choose</a>
                                </div>

                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                                    <p class="uppercase text-lg text-center font-medium">Diamond</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Unlimited Posts Collections from
                                        Facebook, Instagram, Twitter and Tiktok.
                                        All Free.
                                    </p>
                                    <p class="text-2xl text-center uppercase my-3 font-medium">$99</p>
                                    <a href="#" class="bg-transparent text-blue-550 px-4 py-1.5 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white">Choose</a>
                                </div>

                                <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                                    <p class="uppercase text-lg text-center font-medium">Diamond</p>
                                    <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                                    <hr class="w-3/5 mx-auto border-gray-900 my-3">
                                    <p class="text-center">
                                        Unlimited Posts Collections from
                                        Facebook, Instagram, Twitter and Tiktok.
                                        Discounted & All Free.
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
