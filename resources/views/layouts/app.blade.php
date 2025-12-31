<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AturUangmu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/custom.js'])
</head>
<body class="bg-[#f8fafc] font-sans antialiased">
    @include('layouts.navigation')
    {{ $slot }}
</body>
</html>