<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 100px;
            height: 100vh;
            background-color: blue;
            color: white;
            padding: 16px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-top: 75%;
        }
        .sidebar-menu a {
            text-decoration: none;
            color: white;
            transition: opacity 0.3s;
            cursor: pointer;
            font-weight: bold;
        }
        .sidebar-menu a:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        function goToDashboard() {
            window.location.href = "/"; // Mengarahkan ke halaman Dashboard
        }

        // function onLogout() {
        //     fetch("{{ route('logout') }}", {
        //         method: "POST",
        //         headers: {
        //             "Content-Type": "application/json",
        //             "X-CSRF-TOKEN": "{{ csrf_token() }}"
        //         },
        //         body: JSON.stringify({})
        //     }).then(response => {
        //         if (response.ok) {
        //             window.location.href = "/";
        //         } else {
        //             alert("Logout failed");
        //         }
        //     }).catch(error => console.error("Error:", error));
        // }
    </script>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-menu">
            <a onclick="goToDashboard()">Dashboard</a>
            <a>Profile</a>
            {{-- <a onclick="onLogout()">Logout</a> --}}
            <a>Settings</a>
            <a href="/change-password">ChangePass</a>
            <a href="{{route ('chose')}}">History</a>
            <a href="{{route ('Editalat')}}">Edit Alat</a>
            <a href="{{route ('admin.create')}}">Tambah Alat</a>
        </div>
    </aside>
</body>
</html>
