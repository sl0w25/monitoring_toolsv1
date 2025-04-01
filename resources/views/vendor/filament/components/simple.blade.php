<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Login</title>
    @vite('resources/css/app.css') <!-- Ensure your CSS is included -->
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center"
      style="background-image: url('{{ asset('images/pilipinas.jpg') }}');">

    <div class="w-full max-w-md p-8 bg-white/80 backdrop-blur-md rounded-lg shadow-lg">
        {{ $slot }}
    </div>

</body>
</html>
