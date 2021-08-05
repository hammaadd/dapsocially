<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - DapSocially</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    @include('users.inc.fonts')
    <script src="{{asset('js/alpine.min.js')}}" defer></script>
    @yield('headerExtra')
</head>
