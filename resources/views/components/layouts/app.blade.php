@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - AturUangmu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/modal-handler.js','resources/js/app.js',  'resources/js/custom.js', 'resources/js/dashboard.js', ])
</head>
<body class="bg-[#f8fafc] font-sans antialiased">
   <x-layouts.navigation />
    {{ $slot }}
    @stack('scripts')
</body>
</html>