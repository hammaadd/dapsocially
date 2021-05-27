@extends('admin.layout.adminlayout')
@section('title', 'Dashboard')

@section('content')

    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
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
                  {data:'id',name:'Id'},
                  {data: 'name', name: 'Name'},
                  {data: 'email', name: 'Email'},
                  {data: 'action', name: 3, orderable: false, searchable: false},
              ]
          });
        });

    </script>
    
@endsection
