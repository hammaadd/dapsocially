@extends('admin.layout.adminlayout')
@section('title', 'Assign Permissions')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">User List</a></li>
        <li class="breadcrumb-item active" aria-current="page">deassign Permission</li>
    </ol>
</nav>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card rolecard">
                    <div class="card-header">
                        <h4 class="card-title">Assign Permission</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('deassign.permission') }}">  
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                       
                                            <label>Role</label>
                                        </div>
                                        <div class="form-group">
                                            
                                            <select class="choices form-select" id="role" name="role">
                                                <optgroup label="Permissions">
                                                 
                                                    <option value="{{ $role->display_name }}">{{ $role->display_name }}</option>
                                                     
                                                    
                                                   
                                                </optgroup>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Permission Name</label>
                                        </div>
                                        <div class="form-check">
                                           
                                            @foreach ($permissions as $permission)
                                            <div class="checkbox">
                                                
                                              
                                              
                                                <input type="checkbox" id="checkbox1" name="permissions[]" class="form-check-input"
                                                value="{{$permission->name}}" checked>
                                               
                                                <label for="checkbox1">{{$permission->name}}</label>
                                                
                                               
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" >deassign Permission</button>

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