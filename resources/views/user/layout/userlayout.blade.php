@include('user.include.header')

<body>
    @yield('content')
    @include('user.include.scripts')
    @yield('extrascripts')
</body>

</html>
