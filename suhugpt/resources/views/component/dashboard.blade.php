<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Real-Time Suhu & Kelembaban</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .kotak {
            border: 2px solid black; /* Garis tepi kotak */
            padding-left: 5px; /* Ruang di dalam kotak */
            padding-right: 5px;
            background-color: #ffffff; /* Warna latar belakang kotak */
            width: 20%; /* Lebar kotak */
            margin-top: 12%;
            /* margin: 20px 0px 0px 0px; Margin atas/bawah 20px dan tengah secara horizontal */
            border-radius: 10px; /* Sudut kotak yang melengkung */
            margin-left: 73%;
        }
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
</body>
</html>
