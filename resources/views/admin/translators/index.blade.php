@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <button onclick="window.location.href='{{ route('admin.translators.create') }}'" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; margin-bottom: 10px; padding: 5px 20px; border: none; border-radius: 4px;">Добавить переводчика</button>
    
    <div class="table-header">Список переводчиков</div>

    <table class="nova-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Имя</th>
                <th style="padding: 10px;">Город</th>
                <th style="padding: 10px;">Телефон</th>
                <th style="padding: 10px;">Статус</th>
                <th style="padding: 10px; text-align: right;">Действия</th>
            </tr>
        </thead>
        <tbody>
    @foreach($translators as $translator)
        <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #06172a; cursor: pointer;" onclick="window.location.href='{{ route('admin.translators.show', $translator->id) }}'">
            <td style="padding: 10px;">{{ $translator->id }}</td>
            <td style="padding: 10px; font-weight: 500;">{{ $translator->name }}</td>
            <td style="padding: 10px; color: #64748b;">{{ $translator->city }}</td>
            <td style="padding: 10px; color: #64748b;">{{ $translator->phone }}</td>
            <td style="padding: 10px;">
                @if($translator->status === 'active')
                    <span style="background-color: #d1fae5; color: #065f46; padding: 3px 8px; border-radius: 4px; font-size: 12px;">работает</span>
                @else
                    <span style="background-color: #f1f5f9; color: #64748b; padding: 3px 8px; border-radius: 4px; font-size: 12px;">не работает</span>
                @endif
            </td>
            <td style="padding: 10px; text-align: right;" onclick="event.stopPropagation();">
                <!-- Кнопка редактирования -->
                <a href="{{ route('admin.translators.edit', $translator->id) }}" style="color: #3b82f6; text-decoration: none; margin-right: 15px; font-size: 14px;">Изменить</a>
                
                <!-- Кнопка удаления -->
                <button type="button" 
                        onclick="openDeleteModal('{{ route('admin.translators.destroy', $translator->id) }}', '{{ $translator->name }}')" 
                        style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0; font-size: 14px;">
                    Удалить
                </button>
            </td>
        </tr>
    @endforeach
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
    function openDeleteModal(actionUrl, translatorName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const text = document.getElementById('deleteModalText');
        
        form.action = actionUrl;
        text.innerText = `Вы действительно хотите удалить переводчика «${translatorName}»? Это действие нельзя отменить.`;
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    }
</script>
@endsection