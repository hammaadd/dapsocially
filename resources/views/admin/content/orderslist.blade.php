@extends('admin.layout.adminlayout')
@section('title','Orders')
    
@section('content')
<div class="m-5">
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders List</li>
        </ol>
    </nav>
<div class="yajra-t rounded">

    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                
                <th>Type</th>
                <th>Status</th>
                <th>Total payment(USD $)</th>
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
              ajax: "{{ route('get.orders') }}",
              columns: [
                 
                  {data: 'order_type', name: 'Type'},
                  {data: 'order_status', name: 'Status'},
                  {data: 'total_payment', name: 'Total payment'},
                  {data: 'action', name: 4, orderable: false, searchable: false},
              ]
          });
        });

    </script>


@endsection
