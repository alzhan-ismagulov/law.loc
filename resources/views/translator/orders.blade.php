@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 1100px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div style="font-size: 18px; font-weight: 600; color: #0f172a;">
            Мои заказы на перевод и статус выплат
        </div>
        <div style="font-size: 16px; font-weight: 600; color: #0f172a; background: #f8fafc; padding: 8px 15px; border: 1px solid #e2e8f0; border-radius: 6px;">
            Общая сумма: <span style="color: #2563eb;">{{ number_format($totalSum, 2, '.', ' ') }} тг.</span>
        </div>
    </div>

    <!-- Форма сортировки/фильтрации по датам -->
    <form method="GET" action="{{ route('translator.orders') }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
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
            <a href="{{ route('translator.orders') }}" style="color: #64748b; font-size: 13px; text-decoration: none;">Сбросить</a>
        @endif
    </form>

    @forelse($orders as $order)
        @php
            $serviceName = $order->nomenclature?->name ?? 'Услуга перевода';
            if ($order->nomenclature?->parent) {
                $serviceName = $order->nomenclature->parent->name . ' — ' . $order->nomenclature->name;
            }
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; flex-wrap: wrap; gap: 10px;">
                <div>
                    <strong>Заказ #{{ $order->id }}</strong> от {{ $order->order_date }}<br>
                    <span style="color: #64748b; font-size: 13px;">Услуга: {{ $serviceName }}</span>
                </div>
                <div style="text-align: right;">
                    <strong style="font-size: 16px; color: {{ $order->translator_price > 0 ? '#10b981' : '#64748b' }};">
                        {{ number_format($order->translator_price, 2, '.', ' ') }} тг.
                    </strong><br>
                    <div style="margin-top: 4px;">
                        <span style="font-size: 12px; padding: 4px 8px; border-radius: 4px; background: {{ $order->is_translator_paid ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                            {{ $order->is_translator_paid ? 'Оплачено (Выплачено)' : 'Ожидает выплаты' }}
                        </span>
                    </div>
                    @if($order->translator_receipt_path)
                        @php
                            $rawReceiptName = basename($order->translator_receipt_path);
                            $cleanReceiptName = preg_replace('/^\d+_/', '', $rawReceiptName);
                        @endphp
                        <div style="margin-top: 5px; font-size: 12px;">
                            <a href="{{ Storage::url($order->translator_receipt_path) }}" target="_blank" style="color: #3b82f6; text-decoration: none;" title="{{ $cleanReceiptName }}">📎 {{ Str::limit($cleanReceiptName, 25) }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div style="font-size: 14px; font-weight: 500; margin-bottom: 8px;">Файлы по заказу:</div>
            
            @foreach($order->files as $file)
                @php
                    $origExt = $file->original_file_path ? strtolower(pathinfo($file->original_file_path, PATHINFO_EXTENSION)) : '';
                    $transExt = $file->translated_file_path ? strtolower(pathinfo($file->translated_file_path, PATHINFO_EXTENSION)) : '';
                    
                    $rawOrigName = $file->original_file_path ? basename($file->original_file_path) : '';
                    $origFileName = preg_replace('/^\d+_/', '', $rawOrigName);

                    $rawTransName = $file->translated_file_path ? basename($file->translated_file_path) : '';
                    $transFileName = preg_replace('/^\d+_/', '', $rawTransName);

                    $getIcon = function($ext) {
                        if (in_array($ext, ['doc', 'docx'])) return 'word.png';
                        if ($ext === 'pdf') return 'pdf.png';
                        if (in_array($ext, ['xls', 'xlsx', 'csv'])) return 'excel.png';
                        if ($ext === 'txt') return 'txt.png';
                        return 'default.png';
                    };
                @endphp
                
                <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 12px; border-radius: 4px; margin-bottom: 8px; flex-wrap: wrap; gap: 15px;">
                    <!-- Оригинал -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($file->original_file_path)
                            <img src="{{ asset('images/file-icons/' . $getIcon($origExt)) }}" style="width: 22px; height: 22px;">
                            <a href="{{ Storage::url($file->original_file_path) }}" target="_blank" style="color: #3b82f6; text-decoration: none; font-weight: 500;" title="{{ $origFileName }}">{{ Str::limit($origFileName, 22) }}</a>
                        @else
                            Оригинал отсутствует
                        @endif
                        <span style="color: #64748b; font-size: 12px;">({{ $file->original_chars_count }} зн.)</span>
                    </div>

                    <!-- Перевод -->
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($file->translated_file_path)
                            <img src="{{ asset('images/file-icons/' . $getIcon($transExt)) }}" style="width: 22px; height: 22px;">
                            <a href="{{ Storage::url($file->translated_file_path) }}" target="_blank" style="color: #10b981; text-decoration: none; font-weight: 500;" title="{{ $transFileName }}">{{ Str::limit($transFileName, 22) }}</a>
                            <span style="color: #64748b; font-size: 12px;">({{ $file->translated_chars_count }} зн.)</span>
                            
                            <!-- Кнопка удаления перевода -->
                            <form action="{{ route('translator.orders.destroy-translation', $file->id) }}" method="POST" onsubmit="return confirm('Удалить загруженный перевод?');" style="display: inline; margin-left: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 12px; padding: 0;" title="Удалить перевод">Удалить</button>
                            </form>
                        @else
                            <span style="color: #94a3b8; font-size: 13px;">Перевод еще не загружен</span>
                        @endif
                    </div>

                    <!-- Загрузка / Замена -->
                    <form action="{{ route('translator.orders.upload', $file->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 8px; align-items: center;">
                        @csrf
                        <input type="file" name="translated_file" required style="font-size: 12px; max-width: 150px;">
                        <button type="submit" style="background-color: #3b82f6; color: #ffffff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">Загрузить</button>
                    </form>
                </div>
            @endforeach
        </div>
    @empty
        <div style="padding: 30px; text-align: center; color: #64748b; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px;">
            У вас пока нет назначенных заказов.
        </div>
    @endforelse
</div>
@endsection