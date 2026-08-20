<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanger CRM - Личный кабинет</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="nova-layout">
        <aside class="nova-sidebar" id="novaSidebar">
            <div class="sidebar-brand">
                <a href="#" class="brand-link">Legal Core</a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('user.dashboard') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Главная
                </a>
            </nav>
        </aside>

        <main class="nova-main">
            <header class="nova-header">
                <div class="header-left" style="display: flex; align-items: center;">
                    <button type="button" class="nova-mobile-toggle" id-toggle="novaSidebar" onclick="toggleSidebar()">&#9776;</button>
                    <span class="header-dashboard-link">Личный кабинет</span>
                </div>

                <div class="header-user-menu">
                    <div class="user-dropdown-toggle">
                        {{ auth()->user()->name ?? 'Пользователь' }} 
                        <span style="font-size: 11px; opacity: 0.8; font-weight: normal;">
                            @if(auth()->user() && auth()->user()->roles->isNotEmpty())
                                ({{ auth()->user()->roles->pluck('title')->implode(', ') }})
                            @endif
                        </span>
                        &#9662;
                    </div>
                    <div class="user-dropdown-content">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; padding: 8px 16px; font: inherit; color: inherit;">Выйти</button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="nova-content">
                <div class="nova-card-table" style="padding: 30px;">
                    <div class="table-header" style="margin-bottom: 15px;">Добро пожаловать, {{ auth()->user()->name }}!</div>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5;">
                        Ваш аккаунт зарегистрирован в системе. Ожидайте назначения роли (клиента или переводчика) администратором системы.
                    </p>
                </div>
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