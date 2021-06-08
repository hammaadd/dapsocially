@extends('admin.layout.adminlayout')
@section('title', 'Content')

@section('content')
<div class="m-5">
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Content / Add Content</li>
        </ol>
    </nav>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Content</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('add.content') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Key</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="ckey" class="form-control" name="key" placeholder="key">
                                        <span class=" text-danger" role="alert">
                                            @error('key')
                                                <strong>{{ $message }}</strong>
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Heading</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="heading" class="form-control" name="heading" placeholder="heading">
                                        <span class=" text-danger" role="alert">
                                            @error('heading')
                                                <strong>{{ $message }}</strong>
                                            @enderror
                                        </span>
                                    </div>



                                    <div class="row">
                                        <div class="col-12">

                                            <h4 class="card-title">Write Content</h4>
                                            <textarea id="content" name="content" cols="30" rows="10"></textarea>
                                            <span class=" text-danger" role="alert">
                                                @error('content')
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <br>
                                    <br>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 con">Add Content</button>

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
    <script src="{{ asset('admin/assets/vendors/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/tinymce/plugins/code/plugin.min.js') }}"></script>

    <script>
        tinymce.init({
            selector: '#content'
        });
        tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
        });

    </script>


@endsection
