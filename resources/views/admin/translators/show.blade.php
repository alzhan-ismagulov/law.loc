@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 16px; font-weight: 600;">Переводчик: {{ $translator->name }}</div>
        <a href="{{ route('admin.translators.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <!-- Секция добавления пары -->
    <div class="nova-card-table" style="padding: 25px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
        <div style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Добавить языковую пару</div>
        <form action="{{ route('admin.translators.add-pair', $translator->id) }}" method="POST" style="display: flex; gap: 10px;">
            @csrf
            <input type="number" name="source_language_id" class="nova-input" placeholder="ID исх. языка" required>
            <input type="number" name="target_language_id" class="nova-input" placeholder="ID цел. языка" required>
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; border: none; cursor: pointer;">Добавить пару</button>
        </form>
    </div>

    <!-- Секция цен -->
    <div class="nova-card-table" style="padding: 25px; border: 1px solid #e2e8f0;">
        <div style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Языковые пары и тарифы</div>
        
        @foreach($translator->languagePairs as $pair)
            <div style="border: 1px solid #f1f5f9; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <div style="font-weight: 500; margin-bottom: 10px;">Пара: ID {{ $pair->source_language_id }} → ID {{ $pair->target_language_id }}</div>
                
                @php $price = $pair->getActivePriceAttribute(); @endphp
                @if($price)
                    <div style="font-size: 13px; color: #64748b; margin-bottom: 15px;">
                        Актуально с {{ $price->effective_from->format('d.m.Y') }}: 
                        <strong>{{ $price->currency }}</strong> | 
                        Письменный: {{ $price->written_price_1800 }} | 
                        Устный: {{ $price->consecutive_price_hour }} | 
                        Синхрон: {{ $price->simultaneous_price_hour }}
                    </div>
                @endif

                <form action="{{ route('admin.translators.update-price', $pair->id) }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px;">
                        <input type="text" name="currency" class="nova-input" placeholder="Валюта" required>
                        <input type="number" step="0.01" name="written_price_1800" class="nova-input" placeholder="Письм. 1800" required>
                        <input type="number" step="0.01" name="consecutive_price_hour" class="nova-input" placeholder="Устный час" required>
                        <input type="number" step="0.01" name="simultaneous_price_hour" class="nova-input" placeholder="Синхрон" required>
                        <input type="number" step="0.01" name="notarial_fee" class="nova-input" placeholder="Нотариус" required>
                        <input type="number" step="0.01" name="editing_price_1800" class="nova-input" placeholder="Редактура" required>
                        <input type="date" name="effective_from" class="nova-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="nova-input" style="margin-top: 10px; background-color: #10b981; color: #ffffff; border: none; cursor: pointer; padding: 8px 16px;">Сохранить тариф</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection