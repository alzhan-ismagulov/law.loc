<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет клиента - Zanger CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; margin: 0; color: #1e293b; }
        .nova-card-table { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .table-header { font-size: 18px; font-weight: 600; color: #0f172a; }
        .nova-input { border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; }
        .nova-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .nav-link { color: #475569; text-decoration: none; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; display: inline-block; }
        .nav-link:hover, .nav-link.active { background: #f1f5f9; color: #2563eb; }
    </style>
</head>
<body>
    <div style="display: flex; min-height: 100vh;">
        <!-- Сайдбар -->
        <div style="width: 260px; background: #ffffff; border-right: 1px solid #e2e8f0; padding: 20px; display: flex; flex-direction: column;">
            <div style="font-size: 20px; font-weight: 700; color: #2563eb; margin-bottom: 30px; padding-left: 10px;">ZANGER CLIENT</div>
            
            <nav style="display: flex; flex-direction: column; gap: 5px; flex-grow: 1;">
                <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">Главная</a>
                <a href="{{ route('client.orders') }}" class="nav-link {{ request()->routeIs('client.orders') ? 'active' : '' }}">Мои заказы</a>
                <a href="{{ route('client.profile') }}" class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}">Профиль</a>
            </nav>

            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; text-align: left; color: #ef4444; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Выйти</button>
                </form>
            </div>
        </div>

        <!-- Основной контент -->
        <div style="flex-grow: 1; padding: 30px; overflow-y: auto;">
            @yield('content')
        </div>
    </div>
</body>
</html>