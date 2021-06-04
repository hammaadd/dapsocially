@extends('admin.layout.adminlayout')
@section('title', 'User Profile')

@section('content')

    <div class="container">
        <div class="main-body">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">User List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile view</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('user/profile/' . $user->image . '') }}" alt="Admin"
                                    class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-secondary mb-1">{{ $user->profession }}</p>
                                    <p class="text-muted font-size-sm">{{ $user->address }}</p>
                                    @if ($user->isactive == 1)
                                        <a class="btn btn-primary"
                                            href="{{ route('users.activation', ['id' => $user->id, 'status' => 0]) }}">Deactivate</a>

                                    @else
                                        <a class="btn btn-primary"
                                            href="{{ route('users.activation', ['id' => $user->id, 'status' => 1]) }}">Activate</a>

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
                                    {{ $user->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->mobile }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->address }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Role</h6>
                                </div>

                                <div class="col-sm-9 text-secondary">

                                    @foreach ($user->roles as $role)
                                        {{ $role->display_name }},
                                    @endforeach

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">

                                    @if ($user->isactive == 0)
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
@endsection
