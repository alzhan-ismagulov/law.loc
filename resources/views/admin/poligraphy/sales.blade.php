@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; min-width: 600px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a;">Быстрый заказ полиграфических услуг</div>
        
        <!-- Фильтр по периоду -->
        <form method="GET" style="display: flex; gap: 10px; align-items: center;">
            <input type="date" name="start_date" value="{{ $startDate }}" class="nova-input" style="padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <span>—</span>
            <input type="date" name="end_date" value="{{ $endDate }}" class="nova-input" style="padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <button type="submit" class="nova-input" style="background-color: #64748b; color: #fff; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; width: auto;">Показать</button>
        </form>
    </div>

    <!-- Дашбоард с плитками услуг -->
    <div style="font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 10px;">Выберите услугу для быстрого оформления:</div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px; margin-bottom: 30px;">
        @forelse($services as $service)
            <div onclick="openOrderModal('{{ $service->id }}', '{{ $service->name }}', '{{ $service->currentPrice?->selling_price ?? 0 }}')" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#3b82f6'" onmouseout="this.style.borderColor='#cbd5e1'">
                <div style="font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 8px;">{{ $service->name }}</div>
                <div style="font-size: 14px; color: #3b82f6; font-weight: 500;">{{ number_format($service->currentPrice?->selling_price ?? 0, 2, '.', ' ') }} тг.</div>
            </div>
        @empty
            <div style="color: #64748b; grid-column: span 3;">В категории «Услуги» пока нет элементов. Создайте их в справочнике Номенклатура.</div>
        @endforelse
    </div>

    <!-- Аналитика за выбранный период -->
    <div style="display: flex; gap: 20px; margin-bottom: 25px;">
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 6px; flex: 1;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 5px;">Общая выручка за период</div>
            <div style="font-size: 20px; font-weight: 600; color: #0f172a;">{{ number_format($totalRevenue, 2, '.', ' ') }} тг.</div>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 6px; flex: 1;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 5px;">Себестоимость материалов (листов)</div>
            <div style="font-size: 20px; font-weight: 600; color: #ef4444;">{{ number_format($totalMaterialCost, 2, '.', ' ') }} тг.</div>
        </div>
    </div>

    <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 15px;">Журнал заказов за выбранный период</div>

    <table class="nova-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                <th style="padding: 10px;">Дата</th>
                <th style="padding: 10px;">Услуга</th>
                <th style="padding: 10px;">Количество</th>
                <th style="padding: 10px;">Сумма выручки</th>
                <th style="padding: 10px;">Себестоимость матер.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                    <td style="padding: 10px;">{{ $order->order_date->format('d.m.Y') }}</td>
                    <td style="padding: 10px; font-weight: 500;">{{ $order->nomenclature->name }}</td>
                    <td style="padding: 10px;">{{ $order->quantity }}</td>
                    <td style="padding: 10px; font-weight: 500; color: #3b82f6;">{{ number_format($order->total_price, 2, '.', ' ') }} тг.</td>
                    <td style="padding: 10px; color: #64748b;">{{ number_format($order->material_cost, 2, '.', ' ') }} тг.</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #64748b;">Заказов за выбранный период нет</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Модальное окно ввода количества для заказа -->
<div id="orderModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #ffffff; padding: 30px; border-radius: 8px; max-width: 400px; width: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 5px;" id="modalServiceName">Оформление заказа</div>
        <div style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Цена за единицу: <span id="modalServicePrice">0</span> тг.</div>
        
        <form action="{{ route('admin.poligraphy.sales.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nomenclature_id" id="modalNomenclatureId">
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Количество (страниц / шт)</label>
                <input type="number" step="1" name="quantity" id="modalQuantity" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="1" min="1" required oninput="calculateTotal()">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Дата заказа</label>
                <input type="date" name="order_date" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ date('Y-m-d') }}" required>
            </div>

            <div style="font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">
                Итого к оплате: <span id="modalTotalSum" style="color: #3b82f6;">0</span> тг.
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeOrderModal()" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; cursor: pointer; width: auto; padding: 8px 16px; border: none;">Отмена</button>
                <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; width: auto; padding: 8px 16px; border: none;">ОК</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentUnitPrice = 0;

    function openOrderModal(id, name, price) {
        document.getElementById('modalNomenclatureId').value = id;
        document.getElementById('modalServiceName').innerText = name;
        document.getElementById('modalServicePrice').innerText = price;
        currentUnitPrice = parseFloat(price);
        document.getElementById('modalQuantity').value = 1;
        calculateTotal();
        document.getElementById('orderModal').style.display = 'flex';
    }

    function closeOrderModal() {
        document.getElementById('orderModal').style.display = 'none';
    }

    function calculateTotal() {
        let qty = parseFloat(document.getElementById('modalQuantity').value) || 0;
        let total = qty * currentUnitPrice;
        document.getElementById('modalTotalSum').innerText = total.toFixed(2);
    }
</script>
@endsection