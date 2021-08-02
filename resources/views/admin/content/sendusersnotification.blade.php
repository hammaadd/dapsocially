@extends('admin.layout.adminlayout')
@section('title', 'Notifications Management')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card scard">
            <div class="card-header">
                <h4 class="card-title">Send notifications to  users</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal " action="{{ route('send.notifications.freeuse') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">

                                  <div class="col-md-2">
                                    <label>Message</label>
                                </div>
                                <div class="col-md-9 form-group">



                                        <textarea class="form-control" id="quote" rows="5" name="message" placeholder="Write your message here"></textarea>

                                        <span
                                        class="ml-5 text-danger">@error('message'){{ $message }}@enderror</span>

                                        <div class="form-check usercat">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                    checked name="roles[]" value="free">
                                                <label for="checkbox1">Free</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                    checked name="roles[]" value="Diamond">
                                                <label for="checkbox1">Diamond</label>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input"
                                                    checked name="roles[]" value="Silver">
                                                <label for="checkbox1">Silver</label>
                                            </div>

                                        </div>

                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Send Message</button>

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
