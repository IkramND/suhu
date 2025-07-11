<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .navbar {
            background-color: #000000;
            color: white;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .content {
            margin-top: 70px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 25px;
            padding-right: 25px;
            padding-top: 10px;
            padding-bottom: 10px;


        }

        .navbar-logo {
            font-size: 20px;
            font-weight: bold;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #000000;
            color: white;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            padding: 10px;
            display: none;
            flex-direction: column;
            min-width: 150px;
            z-index: 1001;
        }

        .dropdown-menu.show {
            display: flex;
        }

        .dropdown-menu a {
            color: white;
            padding: 8px 12px;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            cursor: pointer;
        }


        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <i class="fas fa-waveform-path"></i> Monitoring Suhu Ruang Server
            </div>
            <div class="navbar-menu dropdown">
                <button class="dropdown-toggle" onclick="toggleDropdown()">

                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="color: white">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
            </span>
        </button><span class="arrow" id="dropdownArrow">

                <div class="dropdown-menu" id="dropdownMenu">
                    <a onclick="onLogout()">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');
            menu.classList.toggle('show');
            arrow.classList.toggle('open');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown');
            if (!dropdown.contains(event.target)) {
                document.getElementById('dropdownMenu').classList.remove('show');
                document.getElementById('dropdownArrow').classList.remove('open');
            }
        });

        async function onLogout() {
            try {
                let response = await fetch("{{ route('logout') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({})
                });

                if (response.ok) {
                    window.location.href = "/login";
                } else {
                    alert("Logout failed");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            }
        }
    </script>

    <main class="content">
        @yield('mains')
    </main>
</body>
</html>
