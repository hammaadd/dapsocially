@extends('admin.layout.adminlayout')
@section('title', 'Content List')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        <li class="breadcrumb-item active" aria-current="page">Contents List</li>
    </ol>
</nav>
<div class="yajra-t rounded">
    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                
                <th>Key</th>
                <th>Heading</th>
                <th>Content</th>
                <th>Action</th>
                
                
            </tr>
        </thead>
        <tbody>
          
            
    </table>
</div>
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
              ajax: "{{ route('get.contents') }}",
              columns: [
                  {data: 'key', name: 'Key'},
                  {data: 'heading', name: 'Heading'},
                  {data: 'content', name: 2},
                  {data: 'action', name: 3, orderable: false, searchable: false},
              ]
          });
        });

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
