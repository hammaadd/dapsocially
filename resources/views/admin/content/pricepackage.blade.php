@extends('admin.layout.adminlayout')
@section('title','Payment Plans')
    
@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        <li class="breadcrumb-item active" aria-current="page">Payment Plans</li>
    </ol>
</nav>
<div class="col-md-6 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Package</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-horizontal" action="{{route('add.package')}}" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Package Name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="package-name" class="form-control"
                                    name="pname" placeholder="Package Name">
                                    <span class="ml-5 text-danger">@error('pname'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Description</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="descrip" class="form-control"
                                    name="descrip" placeholder="Description">
                                    <span class="ml-5 text-danger">@error('descrip'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Price</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="number" id="price" class="form-control"
                                    name="price" placeholder="Price">
                                    <span class="ml-5 text-danger">@error('price'){{ $message }}@enderror</span>
                            </div>
                            <div class="col-md-4">
                                <label>Time Period</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="time-period" class="form-control"
                                    name="timep" placeholder="Monthly/Yearly">
                                    <span class="ml-5 text-danger">@error('timep'){{ $message }}@enderror</span>
                            </div>
                            
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Add Package</button>
                                
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