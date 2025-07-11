<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body{
            overflow-x: hidden;
        }
    </style>
<body>
<main>
    @extends('component.sidebar')
    @extends('component.navbar')
    @yield('main')
</main>
@yield('script')
</body>
</html>
