<!DOCTYPE html>
<html lang="en">
@include('visitor.inc.header')
<style>
  .preloader{
    display:flex;
    display: -webkit-box;
    display: -ms-flexbox;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    background-color: #ededed;
    position: fixed;
    margin: auto;
    z-index: 999;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    height: 100%;
    width: 100%;
}
</style>
<body class="antialiased overflow-x-hidden">
  <div class="preloader" id="preloader">
    <img src="{{asset('bars.svg')}}" style="width: 10rem;" alt="loader">
</div>
    @yield('content')
    <script src="{{ asset('js/app.js')}}"></script>
    @yield('bodyExtra')
    <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
            $(window).on('load',function () {
                $(function () {
                    $("#preloader").fadeOut("slow");
                });
            })
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
