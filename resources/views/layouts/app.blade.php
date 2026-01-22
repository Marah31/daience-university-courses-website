<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
</main>

</body>
</html>
