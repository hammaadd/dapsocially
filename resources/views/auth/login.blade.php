@include('admin.include.head')

<body class="overflow-hidden">
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">

                    </div>
                    <h1 class="auth-title">Login.</h1>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="email" type="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="password" type="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            Log in
                        </button>


                    </form>
                    {{-- <a href="{{ route('login.google') }}" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        Log in with google
                    </a>
                    <a href="{{ route('login.facebook') }}" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                        Log in with Facebook
                    </a> --}}
                    <div class="text-center mt-5 text-lg fs-4">

                        <p>
                            @if (Route::has('password.request'))
                                <a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>.
                            @endif
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block ">
                <div id="auth-right" class="h-100 d-flex align-items-center justify-content-center">
                    <a href="index.html"><img src="{{ asset('admin/assets/images/logo/logo1.png') }}"
                            style="height: 50px; " alt="Logo"></a>
                </div>
            </div>
        </div>

    </div>
</body>
