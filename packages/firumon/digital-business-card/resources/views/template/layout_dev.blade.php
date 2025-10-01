<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @yield('base')
    @yield('vite')
    <meta charset="utf-8">
    <meta name="description" content="Digital Business Card">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    @stack('meta')

    <link rel="icon" type="image/png" sizes="128x128" href="/icons/favicon-128x128.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="icon" type="image/ico" href="icons/logo-flight.svg">
    @stack('link')

    @stack('script')
    <script src="{{ env('APP_URL') }}/script/VCardProperty.js"></script>
    @auth()<script src="{{ env('APP_URL') }}/script/user/{{\Illuminate\Support\Facades\Auth::id()}}/data.js"></script>
    @endauth<script>@stack('script_content')</script>
</head>
<body>
<div id="q-app"></div>@stack('append_body')
</body>
</html>
