@extends('admin.layout.adminlayout')
@section('title', 'Contact us')

@section('content')
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
       <li class="breadcrumb-item active" aria-current="page">Contact Us Users List</li>
    </ol>
</nav>
    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                
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
              ajax: "{{ route('contactus.get') }}",
              columns: [
                  
                  {data: 'key', name: 'key'},
                  {data: 'heading', name: 'heading'},
                  {data: 'content', name: 2},
              ]
          });
        });

    </script>
    
@endsection
