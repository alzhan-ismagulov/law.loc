@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Панель управления в стиле 1С -->
    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
        <button onclick="window.location.href='{{ route('admin.nomenclatures.create', ['parent_id' => $parentId, 'type' => 'folder']) }}'" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; width: auto; font-size: 14px;">+ Создать папку</button>
        <button onclick="window.location.href='{{ route('admin.nomenclatures.create', ['parent_id' => $parentId, 'type' => 'item']) }}'" class="nova-input" style="background-color: #10b981; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; width: auto; font-size: 14px;">+ Создать элемент</button>
        <button onclick="window.print()" class="nova-input" style="background-color: #64748b; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none; border-radius: 4px; width: auto; font-size: 14px;">Печать</button>
    </div>

    @if($currentFolder)
        <div style="margin-bottom: 15px; font-size: 14px; color: #64748b;">
            <a href="{{ route('admin.nomenclatures.index') }}" style="color: #3b82f6; text-decoration: none;">Корневая папка</a> /
            @if($currentFolder->parent)
                <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $currentFolder->parent_id]) }}" style="color: #3b82f6; text-decoration: none;">{{ $currentFolder->parent->name }}</a> /
            @endif
            <span style="color: #0f172a; font-weight: 500;">{{ $currentFolder->name }}</span>
        </div>
        
        <div style="margin-bottom: 15px;">
            <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $currentFolder->parent_id]) }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 6px 14px; border-radius: 4px; display: inline-block; width: auto; font-size: 13px;">← Назад</a>
        </div>
    @endif

    <div class="table-header" style="font-size: 16px; font-weight: 600; color: #0f172a; margin-top: 15px; margin-bottom: 10px;">Справочник: Номенклатура</div>

    <table class="nova-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                <th style="padding: 10px; width: 60px;">Иконка</th>
                <th style="padding: 10px;">Название</th>
                <th style="padding: 10px;">Стоимость</th>
                <th style="padding: 10px; text-align: right;">Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                    <td style="padding: 10px; font-size: 18px;">
                        @if($item->type === 'folder')
                            📁
                        @else
                            📄
                        @endif
                    </td>
                    <td style="padding: 10px; font-weight: 500;">
                        @if($item->type === 'folder')
                            <a href="{{ route('admin.nomenclatures.index', ['parent_id' => $item->id]) }}" style="color: #3b82f6; text-decoration: none;">{{ $item->name }}</a>
                        @else
                            <a href="{{ route('admin.nomenclatures.show', $item->id) }}" style="color: #0f172a; text-decoration: none;">{{ $item->name }}</a>
                        @endif
                    </td>
                    <td style="padding: 10px; color: #64748b;">
                        @if($item->type === 'item')
                            {{ $item->currentPrice ? number_format($item->currentPrice->selling_price, 2, '.', ' ') : '0.00' }} тг.
                        @else
                            —
                        @endif
                    </td>
                    <td style="padding: 10px; text-align: right;">
                        <a href="{{ route('admin.nomenclatures.show', $item->id) }}" style="color: #0ea5e9; text-decoration: none; margin-right: 10px;">Карточка</a>
                        <a href="{{ route('admin.nomenclatures.edit', $item->id) }}" style="color: #3b82f6; text-decoration: none; margin-right: 10px;">Редактировать</a>
                        <button type="button" onclick="openDeleteModal('{{ route('admin.nomenclatures.destroy', $item->id) }}', '{{ $item->name }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;">Удалить</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">Папка пуста</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Модальное окно подтверждения удаления -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #ffffff; padding: 30px; border-radius: 8px; max-width: 400px; width: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #0f172a;">Подтверждение удаления</div>
        <p id="deleteModalText" style="color: #64748b; font-size: 14px; margin-bottom: 20px;"></p>
        
        <form id="deleteForm" method="POST" style="display: flex; justify-content: flex-end; gap: 10px;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; cursor: pointer; width: auto; padding: 8px 16px; border: none;">Отмена</button>
            <button type="submit" class="nova-input" style="background-color: #ef4444; color: #ffffff; cursor: pointer; width: auto; padding: 8px 16px; border: none;">Удалить</button>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, itemName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const text = document.getElementById('deleteModalText');
        
        form.action = actionUrl;
        text.innerText = `Вы действительно хотите удалить элемент «${itemName}»? Это действие нельзя отменить.`;
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    }
</script>
@endsection 