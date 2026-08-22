@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; min-width: 600px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a;">
            Заказ на перевод №{{ $order->id }}
        </div>
        <div>
            <a href="{{ route('admin.translations.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
        </div>
    </div>

    @php
        $clientRatePerUnit = $order->nomenclature?->currentPrice?->selling_price ?? 0;
    @endphp

    <!-- Информация о заказе -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
        <div>
            <strong>Клиент:</strong> {{ $order->client?->name ?? '—' }}<br>
            <strong>Переводчик:</strong> {{ $order->translator?->name ?? 'Не назначен' }}<br>
            <strong>Услуга:</strong> {{ $order->nomenclature->name ?? 'Перевод документов' }}<br>
            <strong>Дата заказа:</strong> {{ $order->order_date }}
        </div>
        <div>
            <strong>Стоимость пары для клиента (за ед.):</strong> {{ number_format($clientRatePerUnit, 2, '.', ' ') }} тг.<br>
            <strong>Стоимость для клиента:</strong> {{ number_format($order->client_price, 2, '.', ' ') }} тг.<br>
            <strong>Оплата переводчику:</strong> {{ number_format($order->translator_price, 2, '.', ' ') }} тг.<br>
            <strong>Статус заказа:</strong> {{ $order->status }}
        </div>
        @if($order->notes)
            <div style="grid-column: span 2; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 5px;">
                <strong>Примечание к заказу (пожелания клиента):</strong>
                <div style="background: #f8fafc; padding: 10px; border-radius: 4px; margin-top: 5px; color: #334155;">
                    {{ $order->notes }}
                </div>
            </div>
        @endif
    </div>

    <!-- Блок финансовых операций -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin-bottom: 20px;">
        <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">Финансовые операции</div>
        
        <!-- Оплата клиента -->
        <form action="{{ route('admin.translations.toggle-payment', $order->id) }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 280px 1fr auto; align-items: center; gap: 15px; margin-bottom: 20px;">
            @csrf @method('PATCH')
            <input type="hidden" name="type" value="client">
            <div style="font-weight: 500; white-space: nowrap;">
                Оплата клиента: 
                <span style="font-size: 11px; padding: 2px 8px; border-radius: 4px; display: inline-block; background: {{ $order->is_client_paid ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                    {{ $order->is_client_paid ? 'Оплачен' : 'Не оплачен' }}
                </span>
            </div>
            <input type="file" name="payment_receipt" style="font-size: 12px; width: 100%; font-weight: normal; font-style: normal; text-transform: none;">
            <button type="submit" style="background-color: {{ $order->is_client_paid ? '#64748b' : '#3b82f6' }}; color: white; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; white-space: nowrap;">
                {{ $order->is_client_paid ? 'Отменить оплату' : 'Подтвердить оплату' }}
            </button>
        </form>

        <!-- Выплата переводчику -->
        <form action="{{ route('admin.translations.toggle-payment', $order->id) }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 280px 1fr auto; align-items: center; gap: 15px;">
            @csrf @method('PATCH')
            <input type="hidden" name="type" value="translator">
            <div style="font-weight: 500; white-space: nowrap;">
                Выплата переводчику: 
                <span style="font-size: 11px; padding: 2px 8px; border-radius: 4px; display: inline-block; background: {{ $order->is_translator_paid ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                    {{ $order->is_translator_paid ? 'Оплачен' : 'Не оплачен' }}
                </span>
            </div>
            <input type="file" name="payment_receipt" style="font-size: 12px; width: 100%; font-weight: normal; font-style: normal; text-transform: none;">
            <button type="submit" style="background-color: {{ $order->is_translator_paid ? '#64748b' : '#3b82f6' }}; color: white; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px; white-space: nowrap;">
                {{ $order->is_translator_paid ? 'Отменить оплату' : 'Подтвердить оплату' }}
            </button>
        </form>
    </div>

    <!-- Блок файлов -->
    <div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 10px;">Файлы по заказу</div>
    
    @foreach($order->files as $file)
        @php
            $origExt = $file->original_file_path ? strtolower(pathinfo($file->original_file_path, PATHINFO_EXTENSION)) : '';
            $transExt = $file->translated_file_path ? strtolower(pathinfo($file->translated_file_path, PATHINFO_EXTENSION)) : '';

            $rawOrigName = $file->original_file_path ? basename($file->original_file_path) : '';
            $origFileName = preg_replace('/^\d+_/', '', $rawOrigName);

            $rawTransName = $file->translated_file_path ? basename($file->translated_file_path) : '';
            $transFileName = preg_replace('/^\d+_/', '', $rawTransName);

            $getIcon = function($ext) {
                $ext = strtolower(trim($ext));
                if ($ext === 'pdf') return 'pdf.png';
                if (in_array($ext, ['doc', 'docx'])) return 'word.png';
                if (in_array($ext, ['xls', 'xlsx', 'csv'])) return 'excel.png';
                if ($ext === 'txt') return 'txt.png';
                return 'default.png';
            };
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <strong>Оригинал:</strong> 
                    @if($file->original_file_path)
                        <img src="{{ asset('images/file-icons/' . $getIcon($origExt)) }}" style="width: 20px; height: 20px;">
                        <a href="{{ Storage::url($file->original_file_path) }}" target="_blank" style="color: #3b82f6; text-decoration: none; font-weight: 500;" title="{{ $origFileName }}">
                            {{ $origFileName }}
                        </a>
                        <span style="color: #64748b; font-size: 13px;">({{ $file->original_chars_count ?? 0 }} зн.)</span>
                    @else Нет файла @endif
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <strong>Перевод:</strong> 
                    @if($file->translated_file_path)
                        <img src="{{ asset('images/file-icons/' . $getIcon($transExt)) }}" style="width: 20px; height: 20px;">
                        <a href="{{ Storage::url($file->translated_file_path) }}" target="_blank" style="color: #10b981; text-decoration: none; font-weight: 500;" title="{{ $transFileName }}">
                            {{ $transFileName }}
                        </a>
                        <span style="color: #64748b; font-size: 13px;">({{ $file->translated_chars_count ?? 0 }} зн.)</span>
                    @else <span style="color: #94a3b8;">Не загружен</span> @endif
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <form action="{{ route('admin.translations.files.upload', $file->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 5px; align-items: center;">
                    @csrf
                    <input type="file" name="translated_file" required style="font-size: 11px; width: 160px; font-weight: normal; font-style: normal; text-transform: none;">
                    <button type="submit" style="background-color: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Загрузить</button>
                </form>
                <form action="{{ route('admin.translations.files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Удалить файл?');">
                    @csrf @method('DELETE')
                    <button type="submit" style="background-color: #fee2e2; color: #991b1b; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Удалить</button>
                </form>
            </div>
        </div>
    @endforeach

</div>
@endsection