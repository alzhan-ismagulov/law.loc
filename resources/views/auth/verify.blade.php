<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение email</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8fafc;">

    <div class="nova-card-table" style="width: 100%; max-width: 400px; padding: 30px; background: #fff; border-radius: 8px;">
        <h2 style="text-align: center; color: #0f172a;">Подтверждение</h2>
        <p style="text-align: center; color: #64748b; font-size: 14px;">Введите 6-значный код, отправленный на ваш email.</p>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 6px; font-size: 13px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf
            <input type="text" name="code" class="nova-input" placeholder="000000" maxlength="6" style="width: 100%; text-align: center; font-size: 20px; letter-spacing: 5px; margin-bottom: 20px;" required>
            <button type="submit" class="nova-input" style="width: 100%; background: #3b82f6; color: #fff; border: none; padding: 10px; cursor: pointer;">Подтвердить</button>
        </form>
    </div>
</body>
</html>