@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 800px;">
    
    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">
        {{ request('type') === 'folder' ? 'Создание папки' : 'Создание элемента номенклатуры' }}
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.nomenclatures.store') }}" method="POST">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $parentId }}">
        <input type="hidden" name="type" value="{{ request('type', 'folder') }}">

        @if(request('type') === 'item')
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Категория</label>
                <select name="category_type" id="categoryTypeSelect" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" onchange="toggleFields()">
                    <option value="Материалы">Материалы</option>
                    <option value="Товары">Товары</option>
                    <option value="Услуги">Услуги</option>
                </select>
            </div>
        @else
            <input type="hidden" name="category_type" value="">
        @endif

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Название</label>
            <input type="text" name="name" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required value="{{ old('name') }}">
        </div>

        @if(request('type') === 'item')
            <div style="margin-bottom: 15px;">
    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Базовая единица</label>
    <select name="base_unit" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
        <option value="шт." {{ (old('base_unit', $nomenclature->base_unit ?? 'шт.') === 'шт.') ? 'selected' : '' }}>шт. (штука / лист)</option>
        <option value="стр." {{ (old('base_unit', $nomenclature->base_unit ?? '') === 'стр.') ? 'selected' : '' }}>стр. (страница перевода, 1800 зн.)</option>
        <option value="дело" {{ (old('base_unit', $nomenclature->base_unit ?? '') === 'дело') ? 'selected' : '' }}>дело (для судебных процессов)</option>
        <option value="усл." {{ (old('base_unit', $nomenclature->base_unit ?? '') === 'усл.') ? 'selected' : '' }}>усл. (разовая услуга / консультация)</option>
        <option value="час" {{ (old('base_unit', $nomenclature->base_unit ?? '') === 'час') ? 'selected' : '' }}>час (почасовая оплата)</option>
    </select>
</div>

            <!-- Блоки складской закупки (скрываются для Услуг) -->
            <div id="stockFieldsGroup">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Единица закупки (например, пачка, коробка — если отличается)</label>
                    <input type="text" name="purchase_unit" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('purchase_unit') }}">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Коэффициент пересчета (сколько базовых единиц в единице закупки, например 500)</label>
                    <input type="number" step="0.0001" name="conversion_factor" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('conversion_factor', 1) }}">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Цена покупки</label>
                    <input type="number" step="0.01" name="purchase_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('purchase_price', 0) }}">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Цена продажи</label>
                <input type="number" step="0.01" name="selling_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('selling_price', 0) }}">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Дата актуальности цены</label>
                <input type="date" name="effective_date" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('effective_date', date('Y-m-d')) }}" required>
            </div>
        @endif

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; width: auto;">Сохранить</button>
            <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $parentId]) }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; display: inline-block; width: auto; text-align: center;">Отмена</a>
        </div>
    </form>
</div>

<script>
    function toggleFields() {
        const select = document.getElementById('categoryTypeSelect');
        const stockGroup = document.getElementById('stockFieldsGroup');
        if (!select || !stockGroup) return;

        if (select.value === 'Услуги') {
            stockGroup.style.display = 'none';
        } else {
            stockGroup.style.display = 'block';
        }
    }

    // Запускаем при загрузке на случай старых значений
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection