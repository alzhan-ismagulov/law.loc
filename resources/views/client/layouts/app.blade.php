<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет клиента - Zanger CRM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="nova-layout">
        <aside class="nova-sidebar" id="novaSidebar">
            <div class="sidebar-brand">
                <a href="{{ route('client.dashboard') }}" class="brand-link">LEGAL CORE CLIENT</a>
            </div>

            <button type="button" class="nova-mobile-toggle" onclick="document.querySelector('.nova-sidebar').classList.toggle('open')">☰</button>
            
            <nav class="sidebar-nav">
                <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">&#9632;</span> Главная
                </a>

                <div class="sidebar-footer-title" style="padding-top: 15px;">РАБОТА</div>

                <a href="{{ route('client.orders') }}" class="nav-link {{ request()->routeIs('client.orders') ? 'active' : '' }}">
                    <span class="nav-icon">&#9632;</span> Мои заказы
                </a>

                <a href="{{ route('client.profile') }}" class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}">
                    <span class="nav-icon">&#9632;</span> Профиль
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link footer-link" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; color: #ef4444; font: inherit;">Выйти</button>
                </form>
            </div>
        </aside>

        <main class="nova-main">
            <header class="nova-header">
                <div class="header-left" style="display: flex; align-items: center;">
                    <button type="button" class="nova-mobile-toggle" id-toggle="novaSidebar" onclick="toggleSidebar()">&#9776;</button>
                    <a href="{{ route('client.dashboard') }}" class="header-dashboard-link">Личный кабинет</a>
                </div>

                <form action="{{ route('client.orders') }}" method="GET" class="header-search" style="margin: 0;">
                    <input type="text" name="search" value="{{ request('search') }}" class="nova-input header-search-input" placeholder="Поиск по заказам...">
                </form>

                <div class="header-user-menu">
                    <div class="user-dropdown-toggle">
                        {{ auth()->user()->name ?? 'Клиент' }} 
                        <span style="font-size: 11px; opacity: 0.8; font-weight: normal;">(Клиент)</span>
                        &#9662;
                    </div>
                    <div class="user-dropdown-content">
                        <a href="{{ route('client.profile') }}" class="dropdown-item">Профиль</a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; padding: 8px 16px; font: inherit; color: inherit;">Выйти</button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="nova-content">
                @yield('content')
            </div>

            <footer class="nova-site-footer">
                ТОО "Legal Core" &copy; 2026. Все права защищены.
            </footer>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('novaSidebar');
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>