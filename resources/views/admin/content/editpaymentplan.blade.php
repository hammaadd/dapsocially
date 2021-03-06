@extends('admin.layout.adminlayout')
@section('title','Edit Payment Plans')
    
@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        <li class="breadcrumb-item active" aria-current="page">Edit Payment Plans</li>
    </ol>
</nav>
<div class="col-md-6 col-12">
    <div class="card pcard">
        <div class="card-header">
            <h4 class="card-title">Package</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-horizontal" action="{{route('update.paymentplans')}}" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Package Name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" name="id" value="{{$paymentplans->id}}" hidden>
                                <input type="text" id="package-name" class="form-control"
                                    name="pname" placeholder="Package Name" value="{{$paymentplans->name}}" required>
                                    <span class="ml-5 text-danger">@error('pname'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Description</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="descrip" class="form-control"
                                    name="descrip" placeholder="Description" value="{{$paymentplans->description}}" required>
                                    <span class="ml-5 text-danger">@error('descrip'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Price</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="number" id="price" class="form-control"
                                    name="price" placeholder="Price" value="{{$paymentplans->price}}" required>
                                    <span class="ml-5 text-danger">@error('price'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Time Period</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="time-period" class="form-control"
                                    name="timep" placeholder="Monthly/Yearly" value="{{$paymentplans->t_period}}" required>
                                    <span class="ml-5 text-danger">@error('timep'){{ $message }}@enderror</span>
                            </div>
                            
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Update Package</button>
                                
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