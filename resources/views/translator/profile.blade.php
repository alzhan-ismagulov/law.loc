@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    <div class="table-header" style="margin-bottom: 20px;">Мой профиль</div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
        <div style="display: flex; gap: 20px; align-items: flex-start; margin-bottom: 20px;">
            <div>
                @if($translator->photo_path)
                    <img src="{{ asset('storage/' . $translator->photo_path) }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;" alt="Фото">
                @else
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; border: 2px solid #e2e8f0;">Нет фото</div>
                @endif
            </div>
            <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                <div><strong>Имя:</strong> {{ $translator->name }}</div>
                <div><strong>Email:</strong> {{ $translator->email }}</div>
                <div><strong>Телефон:</strong> {{ $translator->phone }}</div>
                <div><strong>Страна / Город:</strong> {{ $translator->country }}, {{ $translator->city }}</div>
            </div>
        </div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px;">
        <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Реквизиты</div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
            <div><strong>Банк:</strong> {{ $translator->bank_name ?? 'Не указан' }}</div>
            <div><strong>IBAN:</strong> {{ $translator->iban ?? 'Не указан' }}</div>
            <div><strong>Номер карты:</strong> {{ $translator->card_number ?? 'Не указан' }}</div>
            <div><strong>Тип карты:</strong> {{ $translator->card_type ?? 'Не указан' }}</div>
        </div>
    </div>
</div>
@endsection