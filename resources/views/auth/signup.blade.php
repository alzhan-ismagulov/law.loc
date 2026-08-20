<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Legal Core</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f8fafc; margin: 0;">

    <div class="nova-card-table" style="width: 100%; max-width: 400px; padding: 30px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 24px;">
            <h2 style="color: #0f172a; font-size: 20px; font-weight: 600; margin: 0;">Legal Core</h2>
            <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Регистрация нового аккаунта</p>
        </div>

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500; color: #0f172a;">Ваше имя</label>
                <input type="text" name="name" value="{{ old('name') }}" class="nova-input" style="width: 100%;" required autofocus>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500; color: #0f172a;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="nova-input" style="width: 100%;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500; color: #0f172a;">Пароль</label>
                <input type="password" name="password" class="nova-input" style="width: 100%;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500; color: #0f172a;">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" class="nova-input" style="width: 100%;" required>
            </div>

            <button type="submit" class="nova-input" style="width: 100%; background-color: #3b82f6; color: #ffffff; cursor: pointer; border: none; padding: 10px; font-weight: 500; border-radius: 4px; margin-bottom: 15px;">Зарегистрироваться</button>

            <div style="text-align: center; font-size: 13px; color: #64748b;">
                Уже есть аккаунт? <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Войти</a>
            </div>
        </form>
    </div>

</body>
</html>