@extends('admin.layout.adminlayout')
@section('title', 'Edit content')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('show.content') }}">Content List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Content</li>
    </ol>
</nav>
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Content</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('update.content') }}">
                            @csrf
                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>key</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="id" class="form-control" name="id"
                                            placeholder="key" value="{{$Content->id}}" hidden>
                                        <input type="text" id="eckey" class="form-control" name="key"
                                            placeholder="key" value="{{$Content->key}}" disabled>
                                    </div>
                                    @error('key')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        
                                    <div class="col-md-4">
                                        <label>heading</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="heading" class="form-control" name="heading"
                                            placeholder="heading" value="{{$Content->heading}}">
                                            <span class=" text-danger" role="alert">
                                                @error('heading')
                                                    <strong>{{ $message }}</strong>
                                                @enderror
                                            </span>
                                    </div>
                                    
                                    
                                    
                                        <div class="row">
                                            <div class="col-12">
                                                
                                                <h4 class="card-title">Write Content</h4>
                                                <textarea  id="content" name="content" cols="30" rows="10"  >{{$Content->content}}</textarea>
                                                <span class=" text-danger" role="alert">
                                                    @error('content')
                                                        <strong>{{ $message }}</strong>
                                                    @enderror
                                                </span>  
                                            </div>
                                                </div>
                                            
                                 
                        
                        
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 con">Update</button>
                        
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
<script src="{{asset('admin/assets/vendors/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('admin/assets/vendors/tinymce/plugins/code/plugin.min.js')}}"></script>

<script>
    tinymce.init({ selector: '#content' });
    tinymce.init({ selector: '#dark', toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code', plugins: 'code' });
</script>

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
