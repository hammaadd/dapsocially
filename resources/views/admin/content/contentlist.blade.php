@extends('admin.layout.adminlayout')
@section('title', 'Content List')

@section('content')

    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Key</th>
                <th>Heading</th>
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
              ajax: "{{ route('get.contents') }}",
              columns: [
                  {data:'id',name:'Id'},
                  {data: 'key', name: 'Name'},
                  {data: 'heading', name: 'Heading'},
                  {data: 'content', name: 3},
                  {data: 'action', name: 4, orderable: false, searchable: false},
              ]
          });
        });

    </script>
    
@endsection
