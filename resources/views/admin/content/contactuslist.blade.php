@extends('admin.layout.adminlayout')
@section('title', 'Contact us')

@section('content')

    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
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
                  {data:'id',name:'Id'},
                  {data: 'key', name: 'key'},
                  {data: 'heading', name: 'heading'},
                  {data: 'content', name: 3},
              ]
          });
        });

    </script>
    
@endsection
