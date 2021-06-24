@extends('admin.layout.adminlayout')
@section('title', 'Contact us')

@section('content')
<div class="m-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
       <li class="breadcrumb-item active" aria-current="page">Contact us inquiries</li>
    </ol>
</nav>
<div class="yajra-t rounded">
    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
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
              ajax: "{{ route('contactus.get') }}",
              columns: [
                  
                {data: 'name', name: 'Name'},
                  {data: 'email', name: 'Email'},
                  {data: 'message', name: 'Messages'},
                  {data: 'action', name: 3, orderable: false, searchable: false},
              ]
          });
        });

    </script>
    
@endsection
