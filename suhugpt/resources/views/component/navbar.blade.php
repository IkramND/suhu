<!DOCTYPE html>
<html lang="en">
<head>
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
                {{-- <li><a>>Home</a></li>
                <li><a >About</a></li>
                <li><a >Contact</a></li> --}}
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

