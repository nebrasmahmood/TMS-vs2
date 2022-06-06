<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pakket Service Zeeland - PSZ</title>
        <meta name="description" content="Pakket Service Zeeland Website">
        <link rel="shortcut icon" href="{{ asset("images/favicon.ico") }}">


        <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/guest-style.css') }}">
        <link rel="stylesheet" href="{{ asset("assets/css/font-awesome.min.css") }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
