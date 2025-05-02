<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Responsive Sidebar</title>
    <style>
        body {
            margin: 0;
            font-family: "Arial", sans-serif;
        }

        .sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 220px;
    height: 100vh; /* Tinggi penuh */
    background-color: #0f0f0f  ;
    color: white;
    padding: 16px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;

    /* Tambahkan scrolling */
    overflow-y: auto;
    scrollbar-width: thin; /* Agar scrollbar lebih kecil */
    scrollbar-color: #888 #252d37; /* Warna scrollbar */
}

/* Tambahkan tampilan scrollbar khusus untuk browser berbasis WebKit (Chrome, Edge, Safari) */
.sidebar::-webkit-scrollbar {
    width: 8px; /* Lebar scrollbar */
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: #888; /* Warna bagian scroll */
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Warna scroll saat hover */
}

.sidebar::-webkit-scrollbar-track {
    background: #252d37; /* Warna latar belakang scrollbar */
}


        .menu-toggle {
            display: none;
            font-size: 24px;
            color: rgb(0, 0, 0);
            background: none;
            border: none;
            position: absolute;
            top: 105px;
            left: 15px;
            cursor: pointer;
            z-index: 1000;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 50%;
            margin-bottom: 30%
        }

        .sidebar-menu a, .dropdown-btn {
            text-decoration: none;
            color: white;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
            border-radius: 5px;
        }

        .sidebar-menu a:hover, .dropdown-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dropdown-container {
            display: none;
            flex-direction: column;
            padding-left: 20px;
            /* margin-top: px; */
            transition: all 0.3s ease-in-out;
        }

        .dropdown-container a {
            padding: 8px;
            font-size: 14px;
            color: #ececec;
            text-decoration: none;
            transition: color 0.3s, background 0.3s;
            border-radius: 5px;
            margin-top: 7%;
        }

        .dropdown-container a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .dropdown-btn .fa {
            transition: transform 0.3s ease-in-out;
        }

        .dropdown-btn.active .fa {
            transform: rotate(180deg);
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>

    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>

    <aside class="sidebar">
        <div class="sidebar-menu">
            <a onclick="goToDashboard()">Dashboard</a>

            <!-- Dropdown Settings -->
            <button class="dropdown-btn">Settings <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-container">
                <a href="{{route('admin.create')}}">Add Tools</a>
                <a href="{{route('alat.list')}}">List Tools</a>
                <a href="{{route('settings')}}">Add Machine Limit Sensor Configuration</a>
                <a href="{{route('index.configuration')}}">List Machine Limit Sensor Configuration</a>
                <a href="{{route('admin.create.notification')}}">Add Email Configuration</a>
                <a href="{{route('admin.emailnotification.list')}}">List Email Configuration</a>
                <a href="/change-password">Change Password</a>
            </div>

            <!-- Dropdown Report -->
            <button class="dropdown-btn">Report <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-container">
                <a href="{{route('admin.report')}}">Real Time Summary Report </a>
                <a href="{{route('reportdaily')}}">Real Time Daily Report </a>

                <a href="{{route('report.export')}}">Send to Email</a>
                <a href="{{route('index.report')}}">Archive Report</a>
            </div>

            <a onclick="onLogout()">Logout</a>
        </div>
    </aside>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let dropdownBtns = document.querySelectorAll(".dropdown-btn");

            dropdownBtns.forEach(btn => {
                let dropdownMenu = btn.nextElementSibling;

                // Cek apakah dropdown sebelumnya terbuka
                let key = `dropdownOpen-${btn.textContent.trim()}`;
                if (localStorage.getItem(key) === "true") {
                    dropdownMenu.style.display = "flex";
                    btn.classList.add("active");
                }

                btn.addEventListener("click", function () {
                    let isOpen = dropdownMenu.style.display === "flex";

                    // Toggle dropdown
                    dropdownMenu.style.display = isOpen ? "none" : "flex";
                    btn.classList.toggle("active");

                    // Simpan status di localStorage
                    localStorage.setItem(key, !isOpen);
                });
            });

            // Tutup sidebar jika klik di luar sidebar (hanya di layar kecil)
            document.addEventListener("click", function (event) {
                let sidebar = document.querySelector(".sidebar");
                if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !event.target.matches('.menu-toggle')) {
                    sidebar.classList.remove("open");
                }
            });
        });

        function toggleSidebar() {
            document.querySelector(".sidebar").classList.toggle("open");
        }

        function goToDashboard() {
            window.location.href = "/admin";
        }

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
                    window.location.href = "/";
                } else {
                    alert("Logout failed");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            }
        }
    </script>

</body>
</html>
