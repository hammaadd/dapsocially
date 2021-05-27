@extends('admin.layout.adminlayout')
@section('title', 'Edit content')

@section('content')

<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Content</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('update.content') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>key</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="id" class="form-control" name="id"
                                            placeholder="key" value="{{$Content->id}}" hidden>
                                        <input type="text" id="key" class="form-control" name="key"
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
                                    </div>
                                    @error('heading')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                    <section class="section">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Default Editor</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <textarea  id="content" name="content" cols="30" rows="10"  >{{$Content->content}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                        
                        
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                        
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
@section('extrascripts')
<script src="{{asset('admin/assets/vendors/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('admin/assets/vendors/tinymce/plugins/code/plugin.min.js')}}"></script>

<script>
    tinymce.init({ selector: '#content' });
    tinymce.init({ selector: '#dark', toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code', plugins: 'code' });
</script>

    
@endsection
