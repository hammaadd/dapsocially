@extends('admin.layout.adminlayout')
@section('title', 'Dashboard')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">User List</li>
    </ol>
</nav>
    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
               
                <th>Name</th>
                <th>Email</th>
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
              ajax: "{{ route('users.get') }}",
              columns: [
                  
                  {data: 'name', name: 'Name'},
                  {data: 'email', name: 'Email'},
                  {data: 'action', name: 2, orderable: false, searchable: false},
              ]
          });
        });

    </script>
</div>    
@endsection
