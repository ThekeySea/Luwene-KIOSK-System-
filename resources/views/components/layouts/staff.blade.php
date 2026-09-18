<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUWENE Staff</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-dark-950 text-warm-100 antialiased min-h-dvh font-sans">
    {{ $slot }}
    @livewireScripts
</body>
</html>
