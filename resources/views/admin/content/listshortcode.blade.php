@extends('admin.layout.adminlayout')
@section('title','All Short Codes')
    
@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orders List</li>
    </ol>
</nav>
<table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
    <thead>
        <tr>
            
            <th>Key</th>
            <th>Content</th>
            <th>Action</th>
            
        </tr>
    </thead>
    <tbody>


        
    </table>
</div>

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
                    
                    {data: 'key', name: 'Key'},
                    {data: 'content', name: 'Content'},
                    {data: 'action', name: 2, orderable: false, searchable: false},
                ]
            });
          });
  
      </script>

@endsection