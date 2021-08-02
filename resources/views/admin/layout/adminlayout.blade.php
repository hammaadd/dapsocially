@include('admin.include.head')
<body>
    @include('admin.include.sidebar')
    @include('admin.include.header')
    @yield('content') 
    @include('admin.include.footer')
    @include('admin.include.scripts')
    @yield('extrascripts')
</body>

</html>
