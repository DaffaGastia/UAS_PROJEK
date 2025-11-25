<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style>
        body {
            background: #f5f6fa;
        }
        .admin-container {
            padding-top: 25px;
        }
    </style>

</head>
<body>

    {{-- NAVBAR ADMIN --}}
    <x-admin-navbar />

    {{-- CONTENT --}}
    <div class="container admin-container">
        @yield('content')
    </div>
    
        {{-- SCRIPT PLACEHOLDER --}}
    @yield('scripts')


    @stack('scripts')
</body>
</html>
