<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('assets/images/apotek.png') }}">
    @stack('style')

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s ease;
            display: none;
        }

        .sidebar.active {
            display: block;
        }

        .sidebar a {
            padding: 15px 20px;
            text-align: left;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }

        .sidebar .active {
            background-color: #007bff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin: 0;
            }

            .content {
                margin-left: 0;
            }

            .sidebar a {
                padding: 10px;
                text-align: center;
            }
        }

        .btn-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        @media (max-width: 576px) {
            .btn-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    @if (Auth::check())
    <!-- Sidebar (ditampilkan saat login) -->
    <div class="sidebar {{ Auth::check() ? 'active' : 'd-none' }}">
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('user.data_user') }}" class="{{ Request::routeIs('user.data_user') ? 'active' : '' }}">Kelola Akun</a>
            <a href="{{ route('pembelian.admin') }}" class="{{ Request::routeIs('pembelian.admin') ? 'active' : '' }}">Data Pembelian</a>
            <a href="{{ route('landing_page') }}" class="{{ Request::routeIs('landing_page') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('obat.data') }}" class="{{ Request::routeIs('obat.data') ? 'active' : '' }}">Data Obat</a>
            <a href="#" class="{{ Request::routeIs('stok') ? 'active' : '' }}">Stok</a>
            <a href="{{ route('logout') }}" class="{{ Request::routeIs('logout') ? 'active' : '' }}">Logout</a>
        @elseif (Auth::user()->role == 'user')
            <a href="{{ route('landing_page') }}" class="{{ Request::routeIs('landing_page') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('pembelian.order') }}" class="{{ Request::routeIs('pembelian.order') ? 'active' : '' }}">Pembelian</a>
            <a href="{{ route('logout') }}" class="{{ Request::routeIs('logout') ? 'active' : '' }}">Logout</a>
        @endif
    </div>
    @endif

    <!-- Toggle Button for Mobile View -->
    <button class="btn-toggle" onclick="toggleSidebar()">Menu</button>

    <!-- Main Content -->
    <div class="content">
        <div class="container mt-5">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    @stack('script')

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
            const content = document.querySelector('.content');
            content.style.marginLeft = sidebar.classList.contains('active') ? '250px' : '0';
        }
    </script>
</body>

</html>
