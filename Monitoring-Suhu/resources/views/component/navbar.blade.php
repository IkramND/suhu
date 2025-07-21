<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            transition: background 0.3s, color 0.3s;
            background-color: white;
            color: black;
            font-family: 'Inter', sans-serif;

        }

        body.dark-mode {
            background-color: #020016;
            color: #f1f1f1;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 58px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 34px;
            background-color: #ccc;
            transition: 0.4s;
        }

        .slider::before {
            position: absolute;
            content: "🌙";
            height: 24px;
            width: 24px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            transition: 0.4s;
            text-align: center;
            line-height: 24px;
            font-size: 14px;
        }

        input:checked + .slider{
            /* background-color: #000; */
        }

        input:checked + .slider::before {
            transform: translateX(30px);
            content: "🌞";
        }

        /* input::placeholder.darkmode{
            color: purple;
        } */


        .navbar {
            transition: background 0.3s, color 0.3s;
            background-color: white;
            color: black;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        svg{
            color: black;
            /* background: purple */
        }

        body.dark-mode #person{
            color: #f1f1f1;
        }

        body.dark-mode .card{
            background-color:#0f172a
        }

        body.dark-mode .navbar {
            background-color:#020016;
            color:#f1f1f1;
        }

        body.dark-mode .right .line{
            border: 1px solid white;
            width:80%;
        }
        body.dark-mode .line{
            border: 1px solid white;
            width:80%;
        }

        body.dark-mode #icon-history{
            color: white;
        }

        body.dark-mode .menu-toggle{
            color: white;
        }

        body.dark-mode input{
            background: #020016;
            border: 1px #ccc solid;
            border-radius: 5px;
            color: white
        }

        body.dark-mode input::placeholder{
            color: white
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
            height: 60px;
        }

        .navbar-teks {
            font-size: 20px;
            font-weight: bold;
            margin-left: 19%;
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
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 10px;
            display: none;
            flex-direction: column;
            min-width: 150px;
            z-index: 1001;
        }

        body.dark-mode .dropdown-menu {
            background-color: white;
        }

        .dropdown-menu.show {
            display: flex;
        }

        body.dark-mode .dropdown-menu a{
            color: black;
        }

        .dropdown-menu a {
            color: white;
            padding: 8px 12px;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            cursor: pointer;
        }




        @media (max-width: 800px) {
            .menu-toggle {
                display: block;
            }

            .navbar-teks{
                margin-left: 7%;
                min-width: 55%;
                /* background: purple; */
            }
        }

        @media (max-width: 500px ){
            .navbar-teks {
            max-width: 160px;
        }
        }


    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-teks">
                <span>Monitoring Suhu Ruang Server</span>
            </div>

            <div class="navbar-menu dropdown">
                <div class="switch-container">
                    <label class="switch">
                        <input type="checkbox" id="modeToggle">
                        <span class="slider"></span>
                    </label>
                </div>
                <div>
                <button class="dropdown-toggle" onclick="toggleDropdown()">

                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16" id="person">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>

                </button><span class="arrow" id="dropdownArrow">

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a onclick="onLogout()">Logout</a>
                    </div>
                    </div>
            </div>
        </div>
    </nav>

    <script>
        const toggle = document.getElementById('modeToggle');
        const body = document.body;

        if (localStorage.getItem('theme') == 'light') {
            body.classList.remove('dark-mode');
            toggle.checked = true;
        } else {
            body.classList.add('dark-mode');
            toggle.checked = false;
        }

        toggle.addEventListener('change', () => {
            if (toggle.checked) {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            }
        });










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
</body>
<main class="content">
        @yield('mains')
    </main>
</html>
