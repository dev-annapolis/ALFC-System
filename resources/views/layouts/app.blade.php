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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')

</head>
<body>
    <div id="app">
        @if (!in_array(request()->route()->getName(), ['form.show']))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm ps-5 pe-5">
                <a class="navbar-brand" href="{{ url('/') }}">
                    ALFC
                    <!-- {{ config('app.name', 'Laravel') }} -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                            <!-- No Navigations -->
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">HOME</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('Masterlist') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('teams.index') }}">{{ __('Teams') }}</a>
                                    <a class="dropdown-item" href="{{ route('providers.index') }}">{{ __('Provider') }}</a>
                                    <a class="dropdown-item" href="{{ route('alfcBranches.index') }}">{{ __('ALFC Branches') }}</a>
                                    <a class="dropdown-item" href="{{ route('products.index') }}">{{ __('Products') }}</a>
                                    <a class="dropdown-item" href="{{ route('areas.index') }}">{{ __('Areas') }}</a>
                                    <a class="dropdown-item" href="{{ route('sources.index') }}">{{ __('Sources') }}</a>
                                    <a class="dropdown-item" href="{{ route('source_branches.index') }}">{{ __('Source Branches') }}</a>
                                    <a class="dropdown-item" href="{{ route('mode_of_payments.index') }}">{{ __('Mode of Payment') }}</a>
                                    <a class="dropdown-item" href="{{ route('subproducts.index') }}">{{ __('Sub-Products') }}</a>
                                    <a class="dropdown-item" href="{{ route('gdfis.index') }}">{{ __('GDFI') }}</a>


                                </div>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        @endif




        <main>
            @yield('content')
            <div id="viewport-info" style="
            position: fixed;
            top: 90%;
            left: 50%;
            z-index: 10000;
            transform: translate(-50%, -50%);
            background: rgba(247, 201, 241, 0.4);
            padding: .5rem 1rem;
            border-radius: 30px;
        ">
            <div id="xs" class="d-block d-sm-none"></div>
            <div id="sm" class="d-none d-sm-block d-md-none"></div>
            <div id="md" class="d-none d-md-block d-lg-none"></div>
            <div id="lg" class="d-none d-lg-block d-xl-none"></div>
            <div id="xl" class="d-none d-xl-block d-xxl-none"></div>
            <div id="xxl" class="d-none d-xxl-block"></div>
        </div>
        <script>
            function updateViewportDimensions() {
                const width = window.innerWidth;
                document.getElementById("xs").textContent = width < 576 ? `xs (<576px): ${width}px` : '';
                document.getElementById("sm").textContent = width >= 576 && width < 768 ? `sm (≥576px): ${width}px` : '';
                document.getElementById("md").textContent = width >= 768 && width < 992 ? `md (≥768px): ${width}px` : '';
                document.getElementById("lg").textContent = width >= 992 && width < 1200 ? `lg (≥992px): ${width}px` : '';
                document.getElementById("xl").textContent = width >= 1200 && width < 1400 ? `xl (≥1200px): ${width}px` : '';
                document.getElementById("xxl").textContent = width >= 1400 ? `xxl (≥1400px): ${width}px` : '';
            }

            window.addEventListener('resize', updateViewportDimensions);
            window.addEventListener('load', updateViewportDimensions);
        </script>
        </main>
    </div>
</body>
</html>
