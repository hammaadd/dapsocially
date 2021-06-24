@extends('admin.layout.adminlayout')
@section('title', 'Video Ad')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page">Video Ad</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card scard">
            <div class="card-header">
                <h4 class="card-title">Upload ads</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal " action="{{ route('add.video.uploads') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">


                                <div class="col-md-9 form-group">



                                    <div class="ml-2 col-sm-6 uppic">
                                        <div id="msg"></div>

                                          <input type="file" name="vid" class="file adds" accept="video/*" value="{{old('vid')}}">
                                          <div class="input-group my-3">
                                            <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                                            <div class="input-group-append">
                                              <button type="button" class="browse btn btn-primary">Browse...</button>

                                            </div>

                                          </div>
                                          <div id="emailHelp" class="form-text">Upload max size of 20MB</div>
                                          @error('vid')
                                          <strong class="text-danger">The video field is required</strong>
                                      @enderror
                                      </div>



                                      <div class="col-md-6 addtime">
                                        <div class="form-group row align-items-center">
                                            <div class="col-lg-2 col-3">
                                                <label class="col-form-label">Title</label>
                                            </div>
                                            <div class="col-lg-10 col-9">
                                                <input type="text" id="time" class="form-control" name="title"
                                                    placeholder="Ad title" value="{{ old('title') }}">
                                            </div>
                                        </div>
                                        @error('title')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                    </div>
                                    <div class="col-md-6 addtime">
                                        <div class="form-group row align-items-center">
                                            <div class="col-lg-2 col-3">
                                                <label class="col-form-label">Time</label>
                                            </div>
                                            <div class="col-lg-10 col-9">
                                                <input type="text" id="time" class="form-control" name="time"
                                                    placeholder="Enter time in minutes" value="{{ old('time') }}">
                                                    <div id="emailHelp" class="form-text">Please enter time in minutes</div>
                                            </div>
                                        </div>
                                        @error('time')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                    </div>

                                        <div class="form-check adds">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                     name="cat[]"  value="Events">
                                                <label for="checkbox1">Events</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                     name="cat[]" value="Venue">
                                                <label for="checkbox1">Venues</label>
                                            </div>
                                            @error('cat')
                                            <strong class="text-danger">Please select on of the category from above Event/Venue </strong>
                                        @enderror
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                     name="a_type[]" value="Free" >
                                                <label for="checkbox1">Free</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                     name="a_type[]" value="Paid">
                                                <label for="checkbox1">Paid</label>
                                            </div>
                                            @error('a_type')
                                            <strong class="text-danger">Please select on of the category from above free/paid </strong>
                                        @enderror
                                        </div>

                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1 add">Add</button>

                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>





</div>
  @endsection
  @section('extrascripts')
  <script>

$(document).on("click", ".browse", function() {
  var file = $(this).parents().find(".file");
  file.trigger("click");
});
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    // get loaded data and render thumbnail.
    document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
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
