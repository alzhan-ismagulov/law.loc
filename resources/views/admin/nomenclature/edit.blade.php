@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 600px;">
    
    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">
        Редактирование: {{ $nomenclature->name }}
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

    <form action="{{ route('admin.nomenclatures.update', $nomenclature->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="type" value="{{ $nomenclature->type }}">

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Родительская папка</label>
            <select name="parent_id" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;">
                <option value="">-- Корневая папка (без папки) --</option>
                @foreach($folders as $folder)
                    <option value="{{ $folder->id }}" @selected(old('parent_id', $nomenclature->parent_id) == $folder->id)>
                        {{ $folder->display_name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if($nomenclature->type === 'item')
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Категория</label>
                <select name="category_type" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;">
                    <option value="Материалы" @selected($nomenclature->category_type === 'Материалы')>Материалы</option>
                    <option value="Товары" @selected($nomenclature->category_type === 'Товары')>Товары</option>
                    <option value="Услуги" @selected($nomenclature->category_type === 'Услуги')>Услуги</option>
                </select>
            </div>
        @endif

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Название</label>
            <input type="text" name="name" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('name', $nomenclature->name) }}" required>
        </div>

        @if($nomenclature->type === 'item')
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Базовая единица (например, лист, шт, мл)</label>
                <input type="text" name="base_unit" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('base_unit', $nomenclature->base_unit ?? 'шт') }}">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Единица закупки (например, пачка, коробка — если отличается)</label>
                <input type="text" name="purchase_unit" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('purchase_unit', $nomenclature->purchase_unit) }}">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Коэффициент пересчета (сколько базовых единиц в единице закупки, например 500)</label>
                <input type="number" step="0.0001" name="conversion_factor" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('conversion_factor', $nomenclature->conversion_factor ?? 1) }}">
            </div>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin-bottom: 20px;">
                <div style="font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 15px;">Изменение цены (с сохранением истории)</div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Новая цена покупки</label>
                    <input type="number" step="0.01" name="purchase_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('purchase_price', $nomenclature->currentPrice?->purchase_price ?? 0) }}">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Новая цена продажи</label>
                    <input type="number" step="0.01" name="selling_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('selling_price', $nomenclature->currentPrice?->selling_price ?? 0) }}">
                </div>

                <div style="margin-bottom: 0;">
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Дата, с которой действует цена</label>
                    <input type="date" name="effective_date" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ old('effective_date', date('Y-m-d')) }}">
                </div>
            </div>
        @endif

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; width: auto;">Сохранить</button>
            <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $nomenclature->parent_id]) }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; display: inline-block; width: auto; text-align: center;">Отмена</a>
        </div>
    </form>
</div>
@endsection