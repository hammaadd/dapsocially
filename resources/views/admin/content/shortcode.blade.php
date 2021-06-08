@extends('admin.layout.adminlayout')
@section('title', 'Short Codes')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        <li class="breadcrumb-item active" aria-current="page">Short Codes</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card pcard">
            <div class="card-header">
                <h4 class="card-title">Short Codes</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal " action="{{ route('add.code') }}" method="POST">
                        @csrf 
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label><b>Key</b></label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <input type="text" class="form-control" id="key" placeholder="Key" name="key">
                                    <span class="ml-5 text-danger">@error('key'){{ $message }}@enderror</span>

                                  </div>
                                <div class="card ">
                                 <div class="col-md-2">
                                    <label><b>Short Code</b></label>
                                </div>
                                    <div class="card-body">
                                        <div class="form-group with-title mb-3">
                                            <textarea class="form-control" id="quote" rows="5" name="quote"></textarea>

                                           
                                    </div>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add Code</button>
                                   
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
