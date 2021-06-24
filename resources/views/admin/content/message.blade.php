@extends('admin.layout.adminlayout')
@section('title', 'Message for slider')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('all.messages') }}">Messages</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add messages</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card scard">
            <div class="card-header">
                <h4 class="card-title">Message</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('add.message') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Message for</label>
                                </div>
                                <div class="col-md-9 form-group">


                                    <input type="text" class="form-control" id="key" placeholder="Message for Venue/Event" name="key"
                                        value="" >

                                    <span class="ml-5 text-danger">@error('key'){{ $message }}@enderror</span>
                                </div>
                                <div class="col-md-2">
                                    <label>Message</label>
                                </div>
                                <div class="col-md-9 form-group">



                                        <textarea class="form-control" id="quote" rows="5" name="message" placeholder="Write your message here"></textarea>

                                        <span
                                        class="ml-5 text-danger">@error('message'){{ $message }}@enderror</span>

                                </div>




                                        <div class="col-sm-12 d-flex justify-content-end">

                                            <button type="submit" class="btn btn-primary me-1 mb-1">Add message</button>


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
