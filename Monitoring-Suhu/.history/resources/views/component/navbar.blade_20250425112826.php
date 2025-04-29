
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Styling Navbar */
        /* Styling Navbar */
.navbar {
    background-color: #000000  ;
    color: white;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: fixed;
    /* position: absolute; */

    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}

/* Tambahkan margin-top pada konten agar tidak tertutup navbar */
.content {
    margin-top: 70px; /* Sesuaikan dengan tinggi navbar */
}

/* Styling Navbar Container */
.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left:25px;
    padding-right:35px;

    /* max-width: 1200px; */
    margin: 0 auto;
}

/* Styling Navbar Menu */
.navbar-logo {
    font-size: 20px;
    font-weight: bold;
}

.navbar-menu {
    display: flex;
    gap: 24px;
}

.navbar-menu a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: opacity 0.3s;
    cursor: pointer;
}

.navbar-menu a:hover {
    opacity: 0.8;
}

/* Styling Mobile Menu */
.menu-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
}

.mobile-menu {
    display: none;
    flex-direction: column;
    background-color: #1e3a8a;
    padding: 16px;
}

/* Responsiveness */
@media (max-width: 768px) {
    /* .navbar-menu {
        display: none;
    } */
    .menu-toggle {
        display: block;
    }
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-logo">
                <i class="fas fa-waveform-path"></i>
                Monitoring Suhu Ruang Server</a>
            <ul class="navbar-menu">
                <a href="/admin" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="color: white">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </a>
            </ul>
        </div>
    </nav>


    <main>
        @yield('mains')
    </main>
</body>
</html>

