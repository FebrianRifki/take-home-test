<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <i class='bx bx-book-reader'></i>
                <span>PerpusApp</span>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class='bx bx-user'></i> Master Anggota
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class='bx bx-book'></i> Master Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class='bx bx-transfer'></i> Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class='bx bx-archive-in'></i> Pengembalian
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <div class="topbar-title">@yield('title')</div>
                <div class="user-profile">
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color: #ef4444; cursor:pointer; font-size:1.5rem;" title="Logout">
                            <i class='bx bx-log-out-circle'></i>
                        </button>
                    </form>
                </div>
            </header>

            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>