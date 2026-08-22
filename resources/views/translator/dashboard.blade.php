@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 1100px;">
    
    <!-- Приветствие -->
    <div style="font-size: 22px; font-weight: 600; color: #0f172a; margin-bottom: 25px;">
        Добро пожаловать, {{ $translator->name }}!
    </div>
    
    <!-- Блок метрик и показателей -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 30px;">
        
        <!-- Всего заказов -->
        <div style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div style="color: #64748b; font-size: 13px; margin-bottom: 6px;">Всего заказов</div>
            <div style="font-size: 24px; font-weight: 600; color: #0f172a;">{{ $totalOrdersCount }}</div>
        </div>

        <!-- Языковые пары -->
        <div style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div style="color: #64748b; font-size: 13px; margin-bottom: 6px;">Языковых пар</div>
            <div style="font-size: 24px; font-weight: 600; color: #2563eb;">{{ $languagePairsCount }}</div>
        </div>

        <!-- Общая сумма заработка -->
        <div style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div style="color: #64748b; font-size: 13px; margin-bottom: 6px;">Сумма за заказы</div>
            <div style="font-size: 24px; font-weight: 600; color: #0f172a;">{{ number_format($totalEarnedSum, 2, '.', ' ') }} тг.</div>
        </div>

        <!-- Ожидает выплаты -->
        <div style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div style="color: #64748b; font-size: 13px; margin-bottom: 6px;">Ожидает выплаты</div>
            <div style="font-size: 24px; font-weight: 600; color: #dc2626;">{{ number_format($unpaidSum, 2, '.', ' ') }} тг.</div>
        </div>

    </div>

    <!-- Информационная подсказка -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 6px; font-size: 13px; color: #475569; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <span>Выплачено всего: <strong style="color: #059669;">{{ number_format($paidSum, 2, '.', ' ') }} тг.</strong></span>
        <a href="{{ route('translator.orders') }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">Перейти ко всем заказам &rarr;</a>
    </div>

    <!-- Последние заказы -->
    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 15px;">
        Последние заказы
    </div>

    @forelse($orders->take(5) as $order)
        @php
            $serviceName = $order->nomenclature?->name ?? 'Услуга перевода';
            if ($order->nomenclature?->parent) {
                $serviceName = $order->nomenclature->parent->name . ' — ' . $order->nomenclature->name;
            }
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px 20px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <strong>Заказ #{{ $order->id }}</strong> 
                <span style="color: #64748b; font-size: 13px; margin-left: 8px;">от {{ $order->order_date }}</span><br>
                <span style="color: #475569; font-size: 13px;">{{ $serviceName }}</span>
            </div>
            <div style="text-align: right; display: flex; align-items: center; gap: 15px;">
                <div>
                    <strong style="font-size: 15px; color: #0f172a;">{{ number_format($order->translator_price, 2, '.', ' ') }} тг.</strong><br>
                    <span style="font-size: 11px; padding: 2px 6px; border-radius: 4px; background: {{ $order->is_translator_paid ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                        {{ $order->is_translator_paid ? 'Оплачено' : 'Ожидает выплаты' }}
                    </span>
                </div>
                <a href="{{ route('translator.orders') }}" style="background: #f1f5f9; color: #0f172a; padding: 6px 12px; border-radius: 4px; font-size: 12px; text-decoration: none;">Открыть</a>
            </div>
        </div>
    @empty
        <div style="padding: 30px; text-align: center; color: #64748b; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px;">
            У вас пока нет активных заказов.
        </div>
    @endforelse

</div>
@endsection