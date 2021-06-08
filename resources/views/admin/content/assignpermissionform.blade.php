@extends('admin.layout.adminlayout')
@section('title', 'Assign Permissions')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">User List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Assign Permission</li>
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
                            <form class="form form-horizontal" method="POST" action="{{ route('assign.permission') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                       
                                            <label>Role</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="id" name="id" value="{{$id}}" hidden>
                                            <select class="choices form-select" id="permission" name="permission">
                                                <optgroup label="Permissions">
                                                    @foreach ($user->roles as $role)
                                                    <option value="{{ $role->display_name }}">{{ $role->display_name }}</option>
                                                     @endforeach
                                                    
                                                   
                                                </optgroup>
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Permission Name</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="text" id="id" name="id" value="{{$id}}" hidden>
                                            @foreach ($permissions as $permission)
                                            <div class="checkbox">
                                                
                                               
                                                <input type="checkbox" id="checkbox1" name="cat" class="form-check-input"
                                                value="{{$permission->name}}">
                                                <label for="checkbox1">{{$permission->name}}</label>
                                                
                                            </div>
                                            @endforeach
                                        </div>
                                       
                                        
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" disabled>Assign Permission</button>

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
