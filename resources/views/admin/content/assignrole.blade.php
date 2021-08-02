@extends('admin.layout.adminlayout')
@section('title', 'Assign Roles')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">User List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Assign Role</li>
    </ol>
</nav>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card rolecard">
                    <div class="card-header">
                        <h4 class="card-title">Assign Roles</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('giveuser.roles') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Role Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="id" name="id" value="{{$id}}" hidden>
                                            <select class="choices form-select" id="role" name="role">
                                                <optgroup label="Roles">
                                                    @foreach ($roles as $role)
                                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Assign</button>

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