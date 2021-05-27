@extends('admin.layout.adminlayout')
@section('title', 'Assign Permissions')

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Roles</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('assign.permission') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Permission Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="id" name="id" value="{{$id}}" hidden>
                                            <select class="choices form-select" id="permission" name="permission">
                                                <optgroup label="Permissions">
                                                    @foreach ($permissions as $permission)
                                                    <option value="{{$permission->name}}">{{$permission->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Assign Permission</button>

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
@endsection
