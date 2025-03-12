{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Real-Time Suhu & Kelembaban</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .navbar {
            background-color: #ffffff;
            color: blue;
            padding: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        /* margin-bottom: 15px; */
        }
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            height: 30px;
            margin: 0 auto;
        }
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
            color: blue    ;
            transition: opacity 0.3s;
            cursor: pointer;
            font-weight: bold;

        }
        .navbar-menu a:hover {
            opacity: 0.8;

        }
        .menu-toggle {
            display: none;
        }
        .mobile-menu {
            display: none;
            flex-direction: column;
            background-color: #1e3a8a;
            padding: 16px;
        }
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }
            .menu-toggle {
                display: block;
            }
        }
    </style>

    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-logo">MyWebsite</a>
            <ul class="navbar-menu">
                <a onclick="onLogout()">Logout</a>
            </ul>
            <button id="menu-toggle" class="menu-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="mobile-menu">
            <a >Home</a>
            <a >About</a>
            <a >Contact</a>
        </div>
    </nav>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        function onLogout() {
            fetch("{{ route('logout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({})
        }).then(response => {
            if (response.ok) {
                window.location.href = "/";
            } else {
                alert("Logout failed");
            }
        }).catch(error => console.error("Error:", error));
        }
    </script>
    </head>
<body>

</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Grafik Real-Time Suhu & Kelembaban</title> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Styling Navbar */
        /* Styling Navbar */
.navbar {
    background-color: #161a20;
    color: blue;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* position: fixed; */
    position: absolute;

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
    max-width: 1200px;
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
    color: blue;
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
                MyWebsite</a>
            <ul class="navbar-menu">
                <a href="/admin" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="color: blue">
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

