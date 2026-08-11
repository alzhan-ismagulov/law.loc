<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanger CRM - Панель управления</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="nova-layout">
        <aside class="nova-sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link">Zanger CRM</a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Главная
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Категории
                </a>
                <a href="{{ route('admin.tags.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Теги
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Посты
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Клиенты
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Делопроизводство
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Документы
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Настройки
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-footer-title">Справочники</div>
                <a href="#" class="nav-link footer-link">
                    <span class="nav-icon">&#9632;</span> Регионы
                </a>
                <a href="#" class="nav-link footer-link">
                    <span class="nav-icon">&#9632;</span> Сроки
                </a>
            </div>
        </aside>

        <main class="nova-main">
            <header class="nova-header">
                <div class="header-left">
                    <a href="{{ route('admin.dashboard') }}" class="header-dashboard-link">Панель управления</a>
                </div>

                <div class="header-search">
                    <input type="text" class="nova-input header-search-input" placeholder="Поиск по делам...">
                </div>

                <div class="header-user-menu">
                    <div class="user-dropdown-toggle">
                        Администратор &#9662;
                    </div>
                    <div class="user-dropdown-content">
                        <a href="#" class="dropdown-item">Профиль</a>
                        <a href="#" class="dropdown-item">Выйти</a>
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
</body>
</html>