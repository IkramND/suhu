<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Responsive Sidebar</title>
    <style>
        /* Terapkan font yang sama untuk seluruh elemen */
        body {
            margin: 0;
            font-family: "Arial", sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100vh;
            background-color: #252d37;
            color: white;
            padding: 16px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        /* Tombol toggle untuk layar kecil */
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

        /* Dropdown */
        .dropdown-container {
            display: none;
            flex-direction: column;
            padding-left: 20px;
            margin-top: 5px;
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

        /* Rotate icon on active dropdown */
        .dropdown-btn .fa {
            transition: transform 0.3s ease-in-out;
        }

        .dropdown-btn.active .fa {
            transform: rotate(180deg);
        }

        /* Responsiveness */
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

    <!-- Tombol toggle untuk layar kecil -->
    <button class="menu-toggle" onclick="toggleSidebar()">
        ☰
    </button>

    <aside class="sidebar">
        <div class="sidebar-menu">
            <a onclick="goToDashboard()">Dashboard</a>

            <button class="dropdown-btn">Settings
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="{{route('admin.create')}}">Add Tools</a>
                <a href="{{route('alat.list')}}">List Tools</a>
                {{-- <a href="{{route('Editalat')}}">Edit Tools</a> --}}
                <a href="{{route('settings')}}">Add Limit Configuration</a>
                <a href="{{{route('index.configuration')}}}">List Limit Configuration</a>
                <a href="{{route('admin.create.notification')}}">Add Email Configuration</a>
                <a href="/change-password">Change Password</a>

            </div>
            <button class="dropdown-button">Settings
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="{{route('admin.create')}}">Add Tools</a>
                <a href="{{route('alat.list')}}">List Tools</a>
                {{-- <a href="{{route('Editalat')}}">Edit Tools</a> --}}
                <a href="{{route('settings')}}">Add Limit Configuration</a>
                <a href="{{{route('index.configuration')}}}">List Limit Configuration</a>
                <a href="{{route('admin.create.notification')}}">Add Email Configuration</a>
                <a href="/change-password">Change Password</a>

            </div>
            <a href="{{route('admin.report')}}">Report</a>

            <a onclick="onLogout()">Logout</a>

        </div>
    </aside>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let dropdownBtn = document.querySelector(".dropdown-btn");
            let dropdownMenu = document.querySelector(".dropdown-container");
            let sidebar = document.querySelector(".sidebar");

            // Cek apakah dropdown sebelumnya terbuka
            if (localStorage.getItem("dropdownOpen") === "true") {
                dropdownMenu.style.display = "flex";
                dropdownBtn.classList.add("active");
            }

            dropdownBtn.addEventListener("click", function () {
                let isOpen = dropdownMenu.style.display === "flex";

                // Toggle tampilan dropdown
                dropdownMenu.style.display = isOpen ? "none" : "flex";
                dropdownBtn.classList.toggle("active");

                // Simpan status di localStorage
                localStorage.setItem("dropdownOpen", !isOpen);
            });

            // Tutup sidebar jika klik di luar sidebar (hanya di layar kecil)
            document.addEventListener("click", function (event) {
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
