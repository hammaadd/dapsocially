@extends('admin.layout.adminlayout')
@section('title', 'User Profile')

@section('content')
<div class="m-5">
    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.list') }}">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile view</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('user/profile/' . $data['users']->image . '') }}" alt="avtar"
                                    class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{ $data['users']->name }}</h4>
                                    <p class="text-secondary mb-1">{{ $data['users']->profession }}</p>
                                    <p class="text-muted font-size-sm">Address: {{ $data['users']->address }}</p>
                                    @if ($data['users']->isactive == 1)
                                        <a class="btn btn-primary"
                                            href="{{ route('users.activation', ['id' => $data['users']->id, 'status' => 0]) }}">Deactivate</a>

                                    @else
                                        <a class="btn btn-primary"
                                            href="{{ route('users.activation', ['id' => $data['users']->id, 'status' => 1]) }}">Activate</a>

                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $data['users']->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{$data['users']->email }}
                                </div>
                            </div>

                            
                            <hr>
                            
                         
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Role</h6>
                                </div>

                                <div class="col-sm-9 text-secondary">

                                    @foreach ($data['users']->roles as $role)
                                        {{ $role->display_name }},
                                    @endforeach

                                </div>
                            </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Account type</h6>
                                    </div>
    
                                    <div class="col-sm-9 text-secondary">
    
                                      {{$data['order']->account_type}}
    
                                    </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Order Status</h6>
                                </div>

                                <div class="col-sm-9 text-secondary">

                                  {{$data['order']->order_status}}

                                </div>
                        </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">

                                    @if ($data['users']->isactive == 0)
                                        <b class="text-danger"> Status</b>
                                        <a class="btn btn-danger" href="#">Deactive</a>
                                    @else
                                        <b class="text-success"> Status</b>
                                        <button class="btn btn-success">Active</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
@endsection
