@extends('admin.layout.adminlayout')
@section('title', 'Short Codes')

@section('content')
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        <li class="breadcrumb-item active" aria-current="page">Short Codes</li>
    </ol>
</nav>
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Short Codes</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal " action="{{ route('add.code') }}" method="POST">
                        @csrf 
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Key</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <input type="text" class="form-control" id="key" placeholder="Key" name="key">
                                    <span class="ml-5 text-danger">@error('key'){{ $message }}@enderror</span>

                                  </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group with-title mb-3">
                                            <textarea class="form-control" id="quote" rows="5" name="quote"></textarea>

                                            <span
                                                class="ml-5 text-danger">@error('quote'){{ $message }}@enderror</span>
                                                <label>Short Code</label>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add Code</button>
                                   
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




        <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
          <thead>
              <tr>
                  <th>Id</th>
                  <th>Key</th>
                  <th>Content</th>
                  <th>Action</th>
                  
              </tr>
          </thead>
          <tbody>
            
              
      </table>
  @endsection
@section('extrascripts')
      <script>
          $(document).ready(function() {
              $('#example').DataTable();
              
            var table = $('.yajra-data-table').DataTable({
                processing: true,
                serverSide: true,
                "destroy":true,
                ajax: "{{ route('get.shortcode') }}",
                columns: [
                    {data:'id',name:'Id'},
                    {data: 'key', name: 'Key'},
                    {data: 'content', name: 'Content'},
                    {data: 'action', name: 3, orderable: false, searchable: false},
                ]
            });
          });
  
      </script>
{{-- -------------------------------- --}}
{{-- 
                <div class="my-5 mx-5">
                    <table class="table table-sm">
                        <thead>
                            <tr>

                                <th scope="col">Key</th>
                                <th scope="col">Quote</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $values)

                                <tr>

                                    <td>{{ $values->key }}</td>
                                    <td>{{ $values->content }}</td>
                                    <td><a href="{{ route('edit.code', $values) }}"><button type="button"
                                                class="btn btn-success">Edit</button></a></td>
                                    <td><a href="{{ route('delete.code', $values->id) }}"><button type="button"
                                                class="btn btn-danger">Delete</button><a></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}

@endsection