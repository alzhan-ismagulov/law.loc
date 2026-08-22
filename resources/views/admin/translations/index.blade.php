@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 1400px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a;">
            Заказы на перевод
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="font-size: 16px; font-weight: 600; color: #0f172a; background: #f8fafc; padding: 8px 15px; border: 1px solid #e2e8f0; border-radius: 6px;">
                Общая сумма: <span style="color: #2563eb;">{{ number_format($totalSum ?? 0, 2, '.', ' ') }} тг.</span>
            </div>
            <a href="{{ route('admin.translations.create') }}" class="nova-input" style="background-color: #3b82f6; color: #ffffff; text-decoration: none; cursor: pointer; padding: 8px 16px; border-radius: 4px; display: inline-block; font-size: 14px;">+ Новый заказ</a>
        </div>
    </div>

    <!-- Форма сортировки/фильтрации по датам -->
    <form method="GET" action="{{ route('admin.translations.index') }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <div style="display: flex; gap: 8px; align-items: center;">
            <label style="font-size: 13px; color: #475569;">С даты:</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="nova-input" style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <label style="font-size: 13px; color: #475569;">По дату:</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="nova-input" style="padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px;">
        </div>
        <button type="submit" style="background-color: #3b82f6; color: white; border: none; padding: 7px 15px; border-radius: 4px; cursor: pointer; font-size: 13px;">Отфильтровать</button>
        @if(request('date_from') || request('date_to'))
            <a href="{{ route('admin.translations.index') }}" style="color: #64748b; font-size: 13px; text-decoration: none;">Сбросить</a>
        @endif
    </form>

    <table class="nova-table" style="width: 100%; border-collapse: collapse; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 14px; background: #f8fafc;">
                <th style="padding: 12px;">ID / Дата</th>
                <th style="padding: 12px;">Клиент</th>
                <th style="padding: 12px;">Языковая пара</th>
                <th style="padding: 12px;">Файлы</th>
                <th style="padding: 12px;">Переводчик</th>
                <th style="padding: 12px;">Сумма заказа</th>
                <th style="padding: 12px; text-align: right;">Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                @php
                    $translatorPair = $order->translator?->languagePairs()->with(['sourceLanguage', 'targetLanguage', 'prices'])->first();
                    $sourceLang = $translatorPair?->sourceLanguage?->title ?? '';
                    $targetLang = $translatorPair?->targetLanguage?->title ?? '';
                    $pairName = ($sourceLang && $targetLang) ? "$sourceLang → $targetLang" : ($order->nomenclature?->name ?? '—');
                @endphp
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a;">
                    <td style="padding: 12px;">
                        <strong>#{{ $order->id }}</strong><br>
                        <span style="color: #64748b; font-size: 12px;">{{ $order->order_date }}</span>
                    </td>
                    <td style="padding: 12px; font-weight: 500;">{{ $order->client?->name ?? '—' }}</td>
                    <td style="padding: 12px; font-weight: 500;">{{ $pairName }}</td>
                    <td style="padding: 12px; color: #475569;">
                        @if($order->files->count() > 0)
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @foreach($order->files as $file)
                                    @if($file->original_file_path)
                                        @php
                                            $rawName = basename($file->original_file_path);
                                            $cleanName = preg_replace('/^\d+_/', '', $rawName);
                                        @endphp
                                        <a href="{{ Storage::url($file->original_file_path) }}" target="_blank" style="color: #3b82f6; text-decoration: none; font-weight: 500;" title="{{ $cleanName }}">
                                            📄 {{ Str::limit($cleanName, 22) }}
                                        </a>
                                    @else
                                        <span style="color: #94a3b8; font-size: 12px;">Без файла</span>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <span style="color: #94a3b8; font-size: 12px;">Нет файлов</span>
                        @endif
                    </td>
                    <td style="padding: 12px; color: #475569;">{{ $order->translator?->name ?? 'Не назначен' }}</td>
                    <td style="padding: 12px;">
                        <strong>{{ number_format($order->client_price, 2, '.', ' ') }} тг.</strong><br>
                        <form action="{{ route('admin.translations.toggle-payment', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="type" value="client">
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Нажмите, чтобы изменить статус">
                                <span style="font-size: 11px; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 2px; background: {{ $order->is_client_paid ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                                    {{ $order->is_client_paid ? 'Оплачен' : 'Не оплачен' }}
                                </span>
                            </button>
                        </form>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                            <a href="{{ route('admin.translations.show', $order->id) }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Карточка</a>
                            <a href="{{ route('admin.translations.edit', $order->id) }}" style="color: #9d7a52; text-decoration: none; font-weight: 500;">Ред.</a>
                            <button type="button" onclick="openDeleteModal('{{ route('admin.translations.destroy', $order->id) }}', '{{ $order->id }}')" style="background: none; border: none; color: #dc2626; cursor: pointer; font-weight: 500; padding: 0; font: inherit;">Удалить</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 30px; text-align: center; color: #64748b;">Заказы на перевод отсутствуют.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Модальное окно (попап) удаления -->
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #ffffff; padding: 25px; border-radius: 8px; width: 100%; max-width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 10px;">Подтверждение удаления</div>
        <div style="font-size: 14px; color: #475569; margin-bottom: 20px;">
            Вы действительно хотите удалить заказ <strong id="deleteModalOrderId"></strong>? Все связанные файлы также будут удалены с сервера.
        </div>
        <form id="deleteForm" method="POST" style="display: flex; justify-content: flex-end; gap: 10px; margin: 0;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" style="background: #e2e8f0; color: #1e293b; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Отмена</button>
            <button type="submit" style="background: #dc2626; color: #ffffff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Удалить</button>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, orderId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const orderIdSpan = document.getElementById('deleteModalOrderId');
        
        form.action = actionUrl;
        orderIdSpan.textContent = '#' + orderId;
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    }
</script>
@endsection