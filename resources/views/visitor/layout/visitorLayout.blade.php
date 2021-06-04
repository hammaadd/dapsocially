<!DOCTYPE html>
<html lang="en">
@include('visitor.inc.header')
<body>
    @yield('content')
    <script src="{{ asset('js/app.js')}}"></script>
    @yield('bodyExtra')
</body>
</html>
