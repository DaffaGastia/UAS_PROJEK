<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

</body>
</html>
