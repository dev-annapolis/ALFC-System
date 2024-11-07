<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success floating-alert alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- @if ($errors->any())
        <div class="alert alert-danger floating-alert alert-dismissible fade show">
            
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
    <div id="app" class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container row ">
            <div class="first-col shadow-lg p-0 d-none col-md-6 d-md-flex justify-content-center align-items-center">
                <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="ALFC Logo Image">
            </div>
            <div class="second-col shadow-lg col-md-6 d-md-flex justify-content-center align-items-center">
                <div class="w-100 col-12 col-md-9">
                    <div class="d-flex justify-content-center align-items-center p-5">
                        <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="ALFC Logo Image">
                    </div>
                    <form method="POST" action="{{ route('login') }}" style="margin-right:15px; margin-left:15px;" >
                        @csrf

                        <div class="form-group mb-3">
                            <label class="text-secondary" for="username">Username</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                        
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="text-secondary" for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end mt-2 mb-3">
                            <a href="/password/reset" class="text-decoration-underline text-danger ">Forgot Password?</a>
                        </div>
                        <button type="submit" class="login_button btn w-100 fw-bold">Login</button>

                            <!-- Additional section below the login button -->
                        <div class="text-center mt-5 mb-4">
                            <p>Are you new? <a href="/register" class="text-decoration-underline text-danger">Create an Account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

   
</body>
</html>
