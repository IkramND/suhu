<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 17%;
            height: 100%;
            background-color: #020016;
            color: white;
            padding: 16px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #888 #252d37;
            z-index: 1002;
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #252d37;
        }

        .menu-toggle {
            display: none;
            font-size: 24px;
            color: black;
            background: none;
            border: none;
            position: fixed;
            top: 25px;
            left: 15px;
            cursor: pointer;
            z-index: 3000;
        }

        .menu-toggle.white-bg {
            color: white;
            transition: 0.3ms;

        }



        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            /* margin-top: 85px; */
            margin-top: 13px;
            margin-bottom: 30%;
        }


        .sidebar-menu a,
        .dropdown-btn {
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

        .sidebar-menu a:hover,
        .dropdown-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dropdown-container {
            display: none;
            flex-direction: column;
            padding-left: 10px;
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

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 300,
                'GRAD' 100,
                'opsz' 24;
            display: inline-block;
            width: 100%;
            height: 90px;
            font-size: 60px;
            line-height: 90px;
            text-align: center;
            cursor: default;
        }


        @media (max-width: 800px) {
            .sidebar {
                transform: translateX(-100%);
                width: 18%;
                min-width: 120px;
            }


            .sidebar.open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
            }

            .sidebar-menu{
            margin-top: 65px;
            }
        }
    </style>
</head>

<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
    <aside class="sidebar">
        <div class="sidebar-menu">
            <a onclick="goToDashboard()">Dashboard</a>

            <button class="dropdown-btn">Settings <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-container">
                <a href="{{ route('admin.create') }}">Add Tools</a>
                <a href="{{ route('alat.list') }}">Tools List</a>
                <a href="{{ route('settings') }}">Add Machine Limit Sensor Configuration</a>
                <a href="{{ route('index.configuration') }}">Machine Limit Sensor Configuration List</a>
                <a href="{{ route('admin.create.notification') }}">Add Email Configuration</a>
                <a href="{{ route('admin.emailnotification.list') }}">Email Configuration List</a>
                <a href="{{ route('add.calibration') }}">Add Calibration</a>
                <a href="{{ route('calibration.list') }}">Calibration List</a>
                <a href="{{ route('add.dataretention') }}">Data Retention</a>
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('operator.list') }}">Operator List</a>
                <a href="/change-password">Change Password</a>
            </div>

            <button class="dropdown-btn">Report <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-container">
                <a href="{{ route('admin.report') }}">Real Time Summary Report </a>
                <a href="{{ route('reportdaily') }}">Real Time Daily Report </a>
                <a href="{{ route('report.analyze') }}">Temperature Report Analysis (AI)</a>
                <a href="{{ route('report.export') }}">Send to Email</a>
                <a href="{{ route('index.report') }}">Archive Report</a>
            </div>
        </div>
    </aside>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dropdownBtns = document.querySelectorAll(".dropdown-btn");

            dropdownBtns.forEach(btn => {
                let dropdownMenu = btn.nextElementSibling;
                let key = `dropdownOpen-${btn.textContent.trim()}`;
                if (localStorage.getItem(key) === "true") {
                    dropdownMenu.style.display = "flex";
                    btn.classList.add("active");
                }

                btn.addEventListener("click", function() {
                    let isOpen = dropdownMenu.style.display === "flex";
                    dropdownMenu.style.display = isOpen ? "none" : "flex";
                    btn.classList.toggle("active");
                    localStorage.setItem(key, !isOpen);
                });
            });

            document.addEventListener("click", function(event) {
                let sidebar = document.querySelector(".sidebar");
                let toggleBtn = document.querySelector(".menu-toggle");
                if (
                    window.innerWidth <= 800 &&
                    !sidebar.contains(event.target) &&
                    !toggleBtn.contains(event.target)
                ) {
                    sidebar.classList.remove("open");
                }
            });
        });

        function toggleSidebar() {
            const sidebar = document.querySelector(".sidebar");
            const toggleBtn = document.querySelector(".menu-toggle");

            sidebar.classList.toggle("open");
            toggleBtn.classList.toggle("white-bg");

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

</html>
