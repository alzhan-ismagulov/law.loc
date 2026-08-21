@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; min-width: 600px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">Оформление закупки материалов / товаров</div>

    <!-- Форма закупки -->
    <form action="{{ route('admin.poligraphy.purchases.store') }}" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 30px;">
        @csrf
        <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-end;">
            <div style="flex: 3; position: relative;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Номенклатура</label>
                <div style="display: flex; gap: 5px;">
                    <input type="hidden" name="nomenclature_id" id="selectedNomenclatureId" required>
                    <input type="text" id="selectedNomenclatureName" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff;" placeholder="Выберите из справочника..." readonly required>
                    <button type="button" onclick="openNomenclatureModal()" class="nova-input" style="background-color: #64748b; color: #fff; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;" title="Открыть справочник номенклатуры">📁</button>
                </div>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Количество</label>
                <input type="number" step="0.0001" name="quantity" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="1" required>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Цена за единицу</label>
                <input type="number" step="0.01" name="purchase_price" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="0" required>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Дата</label>
                <input type="date" name="purchase_date" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ date('Y-m-d') }}" required>
            </div>
            <div>
                <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; height: 38px;">Сохранить</button>
            </div>
        </div>
    </form>

    <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 15px;">История закупок</div>

    <table class="nova-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                <th style="padding: 10px;">Дата</th>
                <th style="padding: 10px;">Наименование</th>
                <th style="padding: 10px;">Количество</th>
                <th style="padding: 10px;">Цена за ед.</th>
                <th style="padding: 10px;">Итого сумма</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $purchase)
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                    <td style="padding: 10px;">{{ $purchase->purchase_date->format('d.m.Y') }}</td>
                    <td style="padding: 10px; font-weight: 500;">{{ $purchase->nomenclature->name }}</td>
                    <td style="padding: 10px;">{{ $purchase->quantity }} {{ $purchase->nomenclature->purchase_unit ?? $purchase->nomenclature->base_unit }}</td>
                    <td style="padding: 10px;">{{ number_format($purchase->purchase_price, 2, '.', ' ') }} тг.</td>
                    <td style="padding: 10px; font-weight: 500;">{{ number_format($purchase->total_amount, 2, '.', ' ') }} тг.</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #64748b;">Закупок пока нет</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Модальное окно выбора номенклатуры -->
<div id="nomenclatureModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; width: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div style="font-size: 16px; font-weight: 600; color: #0f172a;">Выберите элемент из номенклатуры</div>
            <button type="button" onclick="closeNomenclatureModal()" style="background: none; border: none; font-size: 18px; cursor: pointer;">✕</button>
        </div>
        <table class="nova-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 13px;">
                    <th style="padding: 8px;">Название</th>
                    <th style="padding: 8px;">Категория</th>
                    <th style="padding: 8px; text-align: right;">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Nomenclature::where('type', 'item')->get() as $item)
                    <tr style="border-bottom: 1px solid #f1f5f9; font-size: 13px;">
                        <td style="padding: 8px; font-weight: 500;">{{ $item->name }}</td>
                        <td style="padding: 8px; color: #64748b;">{{ $item->category_type }}</td>
                        <td style="padding: 8px; text-align: right;">
                            <button type="button" onclick="selectNomenclature('{{ $item->id }}', '{{ $item->name }}')" class="nova-input" style="background-color: #3b82f6; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; width: auto;">Выбрать</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function openNomenclatureModal() {
        document.getElementById('nomenclatureModal').style.display = 'flex';
    }
    function closeNomenclatureModal() {
        document.getElementById('nomenclatureModal').style.display = 'none';
    }
    function selectNomenclature(id, name) {
        document.getElementById('selectedNomenclatureId').value = id;
        document.getElementById('selectedNomenclatureName').value = name;
        closeNomenclatureModal();
    }
</script>
@endsection