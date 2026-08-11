@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <button onclick="window.location.href='{{ route('admin.posts.create') }}'" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; margin-bottom: 15px; padding: 8px 20px; border: none; border-radius: 4px; font-size: 14px;">Добавить пост</button>
    
    <div class="table-header" style="margin-bottom: 15px; font-size: 16px; font-weight: 600; color: #0f172a;">Список постов</div>

    <!-- Контейнер с прокруткой для мобильных -->
    <div style="width: 100%; overflow-x: auto;">
        <table class="nova-table" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 13px;">
                    <th style="padding: 12px 10px; width: 60px;">ID</th>
                    <th style="padding: 12px 10px;">Название</th>
                    <th style="padding: 12px 10px;">Категория</th>
                    <th style="padding: 12px 10px; text-align: center; width: 100px;">Просмотры</th>
                    <th style="padding: 12px 10px; width: 140px;">Дата создания</th>
                    <th style="padding: 12px 10px; text-align: right; width: 180px;">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                        <td style="padding: 12px 10px; color: #64748b;">{{ $post->id }}</td>
                        <td style="padding: 12px 10px; font-weight: 500; max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                            {{ $post->title }}
                        </td>
                        <td style="padding: 12px 10px; color: #64748b;">
                            <span style="background-color: #eff6ff; color: #2563eb; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                {{ $post->category->title ?? 'Нет категории' }}
                            </span>
                        </td>
                        <td style="padding: 12px 10px; text-align: center; color: #64748b;">{{ $post->views }}</td>
                        <td style="padding: 12px 10px; color: #64748b; font-size: 13px;">{{ $post->created_at->format('d.m.Y H:i') }}</td>
                        <td style="padding: 12px 10px; text-align: right;">
                            <a href="{{ route('admin.posts.show', $post->id) }}" style="color: #3b82f6; text-decoration: none; margin-right: 12px; font-size: 13px; font-weight: 500;">Просмотр</a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" style="color: #3b82f6; text-decoration: none; margin-right: 12px; font-size: 13px; font-weight: 500;">Изменить</a>
                            <button type="button" onclick="openDeleteModal('{{ route('admin.posts.destroy', $post->id) }}', '{{ $post->title }}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0; font-size: 13px; font-weight: 500;">Удалить</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Пагинация -->
    @if($posts->hasPages())
        <div style="margin-top: 20px;">
            {{ $posts->links() }}
        </div>
    @endif
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
    function openDeleteModal(actionUrl, postTitle) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const text = document.getElementById('deleteModalText');
        
        form.action = actionUrl;
        text.innerText = `Вы действительно хотите удалить пост «${postTitle}»? Это действие нельзя отменить.`;
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    }
</script>
@endsection