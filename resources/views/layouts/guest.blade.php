<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TaskApp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container" style="max-width: 460px">
    <div class="text-center my-4">
        <h1 class="h3 fw-bold">TaskApp</h1>
        <p class="text-muted mb-0">Aplikasi Manajemen Tugas</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
