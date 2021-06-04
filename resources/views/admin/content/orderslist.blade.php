@extends('admin.layout.adminlayout')
@section('title','Orders')
    
@section('content')
<nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orders List</li>
    </ol>
</nav>
    <table id="example" class="table table-striped table-bordered yajra-data-table ml-2" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Order type</th>
                <th>Order status</th>
                <th>Total payment(USD $)</th>
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
              ajax: "{{ route('get.orders') }}",
              columns: [
                  {data:'id',name:'Id'},
                  {data: 'order_type', name: 'Order_type'},
                  {data: 'order_status', name: 'Order_status'},
                  {data: 'total_payment', name: 'Total_payment'},
                  {data: 'action', name: 4, orderable: false, searchable: false},
              ]
          });
        });

    </script>
    
@endsection
