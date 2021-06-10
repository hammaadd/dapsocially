@extends('admin.layout.adminlayout')
@section('title', 'Payment Plans')

@section('content')

<div class="m-5">
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            
            <li class="breadcrumb-item active" aria-current="page">Payment plans</li>
        </ol>
    </nav>
    <div class="yajra-t rounded">
    <table id="usersdata" class="table table-striped table-bordered user-table ml-2" >
        <thead>
            <tr>
               
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
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
                $('#usersdata').DataTable();
                
              var table = $('.user-table').DataTable({
                  processing: true,
                  serverSide: true,
                  "destroy":true,
                  ajax: "{{ route('list.packages') }}",
                  columns: [
                      
                      {data: 'name', name: 'Name'},
                      {data: 'description', name: 'Description'},
                      {data: 'price', name: 'Price'},
                      {data: 'action', name: 3, orderable: false, searchable: false},
                  ]
              });
            });
    
        </script>
    </div>  
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
  