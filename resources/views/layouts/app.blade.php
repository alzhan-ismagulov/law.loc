<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanger CRM - Панель управления</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
    /* Увеличиваем высоту рабочей области CKEditor 5 в два раза */
    .ck-editor__editable {
        min-height: 300px !important;
    }
</style>
</head>
<body>
    <div class="nova-layout">
        <aside class="nova-sidebar" id="novaSidebar">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link">Legal Core</a>
            </div>

            <button type="button" class="nova-mobile-toggle" onclick="document.querySelector('.nova-sidebar').classList.toggle('open')">☰</button>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Главная
                </a>

                <div class="sidebar-footer-title" style="padding-top: 15px;">СПРАВОЧНИКИ</div>
               <a href="{{ route('admin.clients.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Клиенты
                </a>
                

                <!-- Контент (Блог) -->
                <div class="sidebar-footer-title" style="padding-top: 15px;">БЛОГ</div>
                <a href="{{ route('admin.posts.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Посты
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Категории
                </a>
                <a href="{{ route('admin.tags.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Теги
                </a>

                <!-- Юридическое направление -->
                <div class="sidebar-footer-title" style="padding-top: 15px;">ЮРИДИЧЕСКИЙ ОТДЕЛ</div>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Делопроизводство
                </a>

                <!-- Переводческое направление -->
                <div class="sidebar-footer-title" style="padding-top: 15px;">ПЕРЕВОДЧЕСКОЕ БЮРО</div>
                <a href="{{ route('admin.translators.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Переводчики
                </a>

                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Заказы на перевод
                </a>

                <!-- Управление -->
                <div class="sidebar-footer-title" style="padding-top: 15px;">УПРАВЛЕНИЕ</div>
                <a href="#" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Настройки
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-footer-title">СПРАВОЧНИКИ</div>
                <a href="{{ route('admin.regions.index') }}" class="nav-link footer-link">
                    <span class="nav-icon">&#9632;</span> Регионы
                </a>
                <a href="#" class="nav-link footer-link">
                    <span class="nav-icon">&#9632;</span> Сроки
                </a>
                <a href="{{ route('admin.languages.index') }}" class="nav-link">
                    <span class="nav-icon">&#9632;</span> Список языков
                </a>
            </div>
        </aside>

        <main class="nova-main">
            <header class="nova-header">
                <div class="header-left" style="display: flex; align-items: center;">
                    <button type="button" class="nova-mobile-toggle" id-toggle="novaSidebar" onclick="toggleSidebar()">&#9776;</button>
                    <a href="{{ route('admin.dashboard') }}" class="header-dashboard-link">Панель управления</a>
                </div>

                <div class="header-search">
                    <input type="text" class="nova-input header-search-input" placeholder="Поиск по делам...">
                </div>

                <div class="header-user-menu">
    <div class="user-dropdown-toggle">
        {{ auth()->user()->name ?? 'Пользователь' }} 
        <span style="font-size: 11px; opacity: 0.8; font-weight: normal;">
            @if(auth()->user() && auth()->user()->roles->isNotEmpty())
                ({{ auth()->user()->roles->pluck('title')->implode(', ') }})
            @else
                (Гость)
            @endif
        </span>
        &#9662;
    </div>
    <div class="user-dropdown-content">
        <a href="#" class="dropdown-item">Профиль</a>
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