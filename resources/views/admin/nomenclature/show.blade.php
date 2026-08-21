@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 900px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a;">
            Карточка: {{ $nomenclature->name }}
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="nova-input" style="background-color: #64748b; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; width: auto; font-size: 14px;">Печать</button>
            <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $nomenclature->parent_id]) }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; display: inline-block; width: auto; text-align: center; font-size: 14px;">Назад</a>
        </div>
    </div>

    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin-bottom: 25px; font-size: 14px; color: #0f172a;">
        <div style="margin-bottom: 10px;"><strong>Тип:</strong> {{ $nomenclature->type === 'folder' ? 'Папка' : 'Элемент' }}</div>
        @if($nomenclature->type === 'item')
            <div style="margin-bottom: 10px;"><strong>Категория:</strong> {{ $nomenclature->category_type ?? '—' }}</div>
            <div style="margin-bottom: 10px;"><strong>Базовая единица:</strong> {{ $nomenclature->base_unit ?? 'шт' }}</div>
            @if($nomenclature->purchase_unit)
                <div style="margin-bottom: 10px;"><strong>Единица закупки:</strong> {{ $nomenclature->purchase_unit }} (Коэффициент: {{ $nomenclature->conversion_factor }})</div>
                <div style="margin-bottom: 10px;"><strong>Себестоимость 1 базовой ед. (листа):</strong> {{ number_format($nomenclature->base_purchase_price, 2, '.', ' ') }} тг.</div>
            @endif
        @endif
        <div style="margin-bottom: 0;"><strong>Родительская папка:</strong> {{ $nomenclature->parent?->name ?? 'Корневая папка' }}</div>
    </div>

    @if($nomenclature->type === 'item')
        <!-- Блок спецификации (если это услуга) -->
        @if($nomenclature->category_type === 'Услуги')
            <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 15px; margin-top: 30px;">Спецификация (расход материалов на 1 услугу)</div>
            
            <table class="nova-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                        <th style="padding: 10px;">Материал</th>
                        <th style="padding: 10px;">Количество (в баз. ед.)</th>
                        <th style="padding: 10px;">Себестоимость материала</th>
                        <th style="padding: 10px; text-align: right;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nomenclature->bomItems as $bom)
                        <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                            <td style="padding: 10px; font-weight: 500;">{{ $bom->materialItem->name }}</td>
                            <td style="padding: 10px;">{{ $bom->quantity }} {{ $bom->materialItem->base_unit }}</td>
                            <td style="padding: 10px; color: #64748b;">
                                {{ number_format($bom->quantity * $bom->materialItem->base_purchase_price, 2, '.', ' ') }} тг.
                            </td>
                            <td style="padding: 10px; text-align: right;">
                                <form action="{{ route('admin.nomenclatures.bom.destroy', $bom->id) }}" method="POST" onsubmit="return confirm('Удалить материал из спецификации?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0; font-size: 14px;">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 15px; text-align: center; color: #64748b;">Спецификация пуста. Материалы не привязаны.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Форма добавления материала в спецификацию -->
            <form action="{{ route('admin.nomenclatures.bom.store', $nomenclature->id) }}" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; display: flex; gap: 15px; align-items: flex-end;">
                @csrf
                <div style="flex: 2;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Выберите материал</label>
                    <select name="material_item_id" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                        <option value="">-- Выберите --</option>
                        @foreach(\App\Models\Nomenclature::where('category_type', 'Материалы')->where('type', 'item')->get() as $mat)
                            <option value="{{ $mat->id }}">{{ $mat->name }} (закуп в: {{ $mat->purchase_unit ?? $mat->base_unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 13px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Количество</label>
                    <input type="number" step="0.0001" name="quantity" class="nova-input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px;" value="1" required>
                </div>
                <div>
                    <button type="submit" class="nova-input" style="background-color: #10b981; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; height: 38px;">Добавить</button>
                </div>
            </form>
        @endif

        <!-- История цен -->
        <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 15px; margin-top: 30px;">История изменения цен</div>

        <table class="nova-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                    <th style="padding: 10px;">Дата начала действия</th>
                    <th style="padding: 10px;">Цена покупки</th>
                    <th style="padding: 10px;">Цена продажи</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nomenclature->prices as $price)
                    <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                        <td style="padding: 10px;">{{ $price->effective_date->format('d.m.Y') }}</td>
                        <td style="padding: 10px; color: #64748b;">{{ number_format($price->purchase_price, 2, '.', ' ') }} тг.</td>
                        <td style="padding: 10px; font-weight: 500;">{{ number_format($price->selling_price, 2, '.', ' ') }} тг.</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 20px; text-align: center; color: #64748b;">История цен пуста</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection