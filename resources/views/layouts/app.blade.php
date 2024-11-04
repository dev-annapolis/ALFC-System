<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ALFC Insurance Agency Corporation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap 5.3.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    @vite('resources/js/app.js')

</head>
<body>

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



    @yield('content')




    {{-- JQuery 3.7.1 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Bootstrap 5.3.3 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



    <script>
        function updateViewportDimensions() {
            const width = window.innerWidth;
            document.getElementById("xs").textContent = width < 576 ? `Extra Small (<576px): ${width}px` : '';
            document.getElementById("sm").textContent = width >= 576 && width < 768 ? `Small (≥576px): ${width}px` : '';
            document.getElementById("md").textContent = width >= 768 && width < 992 ? `Medium (≥768px): ${width}px` : '';
            document.getElementById("lg").textContent = width >= 992 && width < 1200 ? `Large (≥992px): ${width}px` : '';
            document.getElementById("xl").textContent = width >= 1200 && width < 1400 ? `X-Large (≥1200px): ${width}px` : '';
            document.getElementById("xxl").textContent = width >= 1400 ? `XX-Large (≥1400px): ${width}px` : '';
        }

        window.addEventListener('resize', updateViewportDimensions);
        window.addEventListener('load', updateViewportDimensions);
    </script>

</body>
</html>
