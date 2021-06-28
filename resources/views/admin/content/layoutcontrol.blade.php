@extends('admin.layout.adminlayout')
@section('title', 'Layout setting')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Layout setting</li>
    </ol>
</nav>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card pcard">
                    <div class="card-header">
                        <h4 class="card-title">Layout setting</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('insert.roles') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Time</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="role-name" class="form-control" name="rname"
                                                placeholder="Time for post light box">
                                            <small id="emailHelp" class="form-text text-muted">How much time a post box wil be displayed?</small>
                                        </div>

                                        @error('rname')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>

                                        @enderror
                                        <div class="col-md-4">
                                            <label>Number of posts</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="display" class="form-control" name="display"
                                                placeholder="Number of posts">
                                            <small id="emailHelp" class="form-text text-muted">How many posts before an ad  and  grid display?</small>
                                            @error('display')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Description</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea type="text" id="description" class="form-control" name="description"
                                                placeholder="description"> </textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Add Role</button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
