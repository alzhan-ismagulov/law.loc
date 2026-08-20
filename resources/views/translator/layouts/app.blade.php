<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабинет переводчика - ТОО "Legal Core"</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="nova-layout">
        <aside class="nova-sidebar" id="novaSidebar">
            <div class="sidebar-brand" style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 4px;">
                <a href="{{ route('translator.dashboard') }}" class="brand-link" style="font-weight: 600; font-size: 16px; color: #ffffff; text-decoration: none;">ТОО "Legal Core"</a>
                <span style="font-size: 12px; color: #64748b;">Кабинет переводчика</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('translator.dashboard') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Главная
                </a>
                <a href="{{ route('translator.orders') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Мои заказы
                </a>
                <a href="{{ route('translator.prices') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Мои цены
                </a>
                <a href="{{ route('translator.profile') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Профиль
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 15px 20px;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font: inherit; padding: 0;">Выйти</button>
                </form>
            </div>
        </aside>

        <main class="nova-main">
            <header class="nova-header">
                <div class="header-left" style="display: flex; align-items: center;">
                    <button type="button" class="nova-mobile-toggle" onclick="toggleSidebar()">&#9776;</button>
                    <a href="{{ route('translator.dashboard') }}" class="header-dashboard-link">Панель переводчика</a>
                </div>
                <div class="header-user-menu" style="display: flex; align-items: center; gap: 10px;">
                    @php $translatorUser = auth('translator')->user(); @endphp
                    @if($translatorUser->photo_path)
                        <img src="{{ asset('storage/' . $translatorUser->photo_path) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0;" alt="Фото">
                    @else
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; border: 1px solid #e2e8f0;">Фото</div>
                    @endif
                    <div class="user-dropdown-toggle" style="font-size: 14px; display: flex; flex-direction: column; text-align: right; line-height: 1.2;">
                        <span style="font-weight: 500; color: #0f172a;">{{ $translatorUser->name ?? 'Переводчик' }}</span>
                        <span style="font-size: 11px; color: #64748b;">Переводчик</span>
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
            document.getElementById('novaSidebar').classList.toggle('open');
        }
    </script>
</body>
</html>