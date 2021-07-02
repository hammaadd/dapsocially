<!DOCTYPE html>
<html lang="en">
@include('visitor.inc.header')
<body>
    @yield('content')
    <script src="{{ asset('js/app.js')}}"></script>
    @yield('bodyExtra')
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
              toastr.error("{{ session('error') }}");
      @endif
     </script>
</body>
</html>
