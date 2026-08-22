@extends('client.layouts.app')

@section('content')
<div class="nova-card-table" style="max-width: 900px; padding: 30px;">
    
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
        <h2 style="font-size: 20px; font-weight: 600; color: #0f172a; margin-bottom: 15px;">Добро пожаловать, {{ $client->name ?? 'Клиент' }}!</h2>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; font-size: 14px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px;">
                <p style="color: #64748b; margin-bottom: 5px; font-size: 13px;">Тип аккаунта</p>
                <p style="font-weight: 600; color: #0f172a; font-size: 16px;">{{ $client->type ?? 'Физическое лицо' }}</p>
            </div>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px;">
                <p style="color: #64748b; margin-bottom: 5px; font-size: 13px;">Всего заказов</p>
                <p style="font-weight: 600; color: #3b82f6; font-size: 20px;">{{ $ordersCount ?? 0 }}</p>
            </div>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px;">
                <p style="color: #64748b; margin-bottom: 5px; font-size: 13px;">Город / Регион</p>
                <p style="font-weight: 600; color: #0f172a; font-size: 16px;">{{ $client->city ?? 'Улытау' }}</p>
            </div>
        </div>

        <div style="border-top: 1px solid #e2e8f0; padding-top: 15px; margin-bottom: 20px; font-size: 14px; color: #64748b;">
            <p style="margin-bottom: 3px; font-weight: 600; color: #0f172a;">Контактная информация:</p>
            <p>Email: {{ $client->email }} | Телефон: {{ $client->phone ?? 'Не указан' }}</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('client.orders') }}" style="background: #3b82f6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 14px;">Перейти к моим заказам</a>
            <a href="{{ route('client.profile') }}" style="background: #e2e8f0; color: #334155; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 14px;">Редактировать профиль</a>
        </div>
    </div>

</div>
@endsection