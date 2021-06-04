@extends('admin.layout.adminlayout')
@section('title', 'Short Codes')

@section('content')
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('short.code') }}">Short Codes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit shortcodes</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Short Codes</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('update.code') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Key</label>
                                </div>
                                <div class="col-md-9 form-group">

                                    <input type="text" name='id' id="id" value="{{ $shortQ->id }}" hidden>
                                    <input type="text" class="form-control" id="keys" placeholder="Key" name="keys"
                                        value="{{ $shortQ->key }}" >

                                    <span class="ml-5 text-danger">@error('key'){{ $message }}@enderror</span>
                                    </div>

                                    
                                        <div class="card-body">
                                            <div class="form-group with-title mb-3">
                                                <textarea id="quote" class="form-control" rows="5" name="quote"
                                                    id="quote">{{ $shortQ->content }}</textarea>
                                                <label>Short Code</label>
                                                <span
                                                    class="ml-5 text-danger">@error('quote'){{ $message }}@enderror</span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">

                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>


                                        </div>
                                    
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endsection
