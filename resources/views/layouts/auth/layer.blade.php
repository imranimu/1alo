<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <link rel=icon href="{{ asset('assets/frontend/img/favicon.png') }}" sizes="20x20" type="image/png">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @yield('css')
    @yield('js')

    <script></script>
</head>
@php $common_setting = getSettings(); @endphp

<body>

    <div class="Back">
        <a href="{{ url('/') }}" class="btn-11"><i class="fa fa-arrow-left"></i> Back Website</a>
    </div>


    @yield('content')

    
    <!-- all plugins here -->
    <script src="{{ asset('assets/frontend/js/vendor.js') }}"></script>

    <!-- main js  -->
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script>
        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>

    <style>
        .Back {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .Back a {
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 40px;
        }

        .Back a:hover{
            background: var(--main-color);
            color: #fff;
        }

    </style>

</body>

</html>
