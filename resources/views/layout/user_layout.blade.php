<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('title')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @yield('style')

    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
</head>

<body>
    <div class="container">
        @include('includes.user_navbar')
        @yield('content')
        @include('includes.footer')
    </div>

    <script src="{{ asset('js/form_input.js') }}"></script>
    @yield('js')
</body>

</html>
