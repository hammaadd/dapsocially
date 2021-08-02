@extends('user.layout.userlayout')
@section('title', 'Home')


@section('content')
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Horizontal Form</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" method="POST" action="{{ route('add.venue') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Venue Name</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="vname" class="form-control" name="vname"
                                        placeholder="Venue Name">
                                </div>
                                @error('vname')
                                    <span class=" text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col-md-4">
                                    <label>Location/City/Address</label>
                                </div>
                                <div class="col-md-8 form-group">

                                    <input id="ship_address" name="ship_address" required autocomplete="off"
                                        class="form-control" />
                                </div>
                                @error('ship_address')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="col-md-4">
                                    <label>City</label>
                                </div>
                                <div class="col-md-8 form-group">

                                    <input id="locality" name="locality" required class="form-control" placeholder="City" />
                                </div>
                                <div class="col-md-4">
                                    <label>State/Province</label>
                                </div>
                                <div class="col-md-8 form-group">

                                    <input id="state" name="state" required class="form-control"
                                        placeholder="Province/State" />
                                </div>
                                <div class="col-md-4">
                                    <label>Country</label>
                                </div>
                                <div class="col-md-8 form-group">

                                    <input id="country" name="country" required class="form-control"
                                        placeholder="Country" />
                                </div>

                                <input type="text" name="latitude" id="latitude" class="form-control" hidden>
                                <input type="text" name="longitude" id="longitude" class="form-control" hidden>

                                <div class="col-md-4">
                                    <label>Add Cover Image</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="file" id="image" class="form-control" name="image" placeholder="Image">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col-md-4">

                                    <label>Venue Description</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <textarea type="text" id="description" class="form-control" name="description"
                                        placeholder="Description"></textarea>
                                </div>
                                @error('description')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col-md-4">

                                    <label>Hastag</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="hashtag" class="form-control" name="hashtag" placeholder="Hashtag">
                                </div>
                                @error('hashtag')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <div class="form-check form-switch">
                                    
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Approve all #hashtags posts from your dapsocially Locations Wall</label>
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                </div>
                                @error('approve')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-check ">
                                    
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Facebook</label>
                                    
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Instagram</label>
                                
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Twitter</label>
                                
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Tiktok</label>
                                </div>
                                @error('approve')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-check ">
                                    
                                    <div class="col-md-4">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label>Facebook</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="hashtag" class="form-control" name="hashtag" placeholder="Enter your public Page id or Username">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label>Instagram</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                       <input type="text" id="hashtag" class="form-control" name="hashtag" placeholder="Enter your public Page id or Username">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label>Twitter</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="hashtag" class="form-control" name="hashtag" placeholder="Enter your public Page id or Username">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        <label>Tiktok</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                       <input type="text" id="hashtag" class="form-control" name="hashtag" placeholder="Enter your public Page id or Username">
                                    </div>
                                
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Background image for social wall</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="file" id="image" class="form-control" name="image" placeholder="Image">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                
                                <div class="col-md-4">
                                    <label>Start Date</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="datetime-local" id="image" class="form-control" name="image" placeholder="Image">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <div class="col-md-4">
                                    <label>End time</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="datetime-local" id="image" class="form-control" name="image" placeholder="Image">
                                </div>
                                @error('image')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                    <label>Message for dapsocial Location Wall</label>
                                
                                <div class="col-md-8 form-group">
                                   <textarea type="text" id="message" class="form-control" name="hashtag" placeholder="Write message here"></textarea>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extrascripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdV4ukitqwrOQ08JZwG7AeLK-6b7cJRhs&callback=initAutocomplete&libraries=places&v=weekly"
        defer></script>
    <script>
        let autocomplete;
        let address1Field;
        let address2Field;
        let postalField;

        function initAutocomplete() {
            address1Field = document.querySelector("#ship_address");
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
@endsection
