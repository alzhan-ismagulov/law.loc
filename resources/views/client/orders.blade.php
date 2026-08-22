@extends('client.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px; max-width: 1100px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div class="table-header" style="margin-bottom: 0; font-size: 18px; font-weight: 600; color: #0f172a;">Мои заказы на перевод и статус выплат</div>
        <div style="font-size: 16px; font-weight: 600; color: #0f172a; background: #f8fafc; padding: 8px 15px; border: 1px solid #e2e8f0; border-radius: 6px;">
            Общая сумма: <span style="color: #3b82f6;">{{ number_format($totalSum ?? 0, 2, '.', ' ') }} тг.</span>
        </div>
    </div>

    <!-- Форма сортировки/фильтрации по датам -->
    <form method="GET" action="{{ route('client.orders') }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
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
            <a href="{{ route('client.orders') }}" style="color: #64748b; font-size: 13px; text-decoration: none;">Сбросить</a>
        @endif
    </form>

    <div style="display: flex; flex-direction: column; gap: 15px;">
        @forelse($orders as $order)
            @php
                $serviceName = $order->nomenclature?->name ?? 'Перевод документов';
                if ($order->nomenclature?->parent) {
                    $serviceName = $order->nomenclature->parent->name . ' — ' . $order->nomenclature->name;
                }

                $clientRatePerUnit = $order->nomenclature?->currentPrice?->selling_price ?? 0;
            @endphp

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; font-size: 14px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 style="font-weight: 600; color: #0f172a; font-size: 16px; margin-bottom: 3px;">Заказ #{{ $order->id }} от {{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</h3>
                        <p style="color: #64748b; margin-bottom: 3px; font-size: 13px;">Услуга: {{ $serviceName }}</p>
                        <p style="color: #475569; font-size: 13px;"><strong>Цена за ед. для клиента:</strong> {{ number_format($clientRatePerUnit, 2, '.', ' ') }} тг.</p>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-weight: 600; color: #0f172a; font-size: 16px; display: block; margin-bottom: 5px;">{{ number_format($order->client_price, 2, '.', ' ') }} тг.</span>
                        @if($order->is_client_paid)
                            <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Оплачено</span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Ожидает оплаты</span>
                        @endif
                    </div>
                </div>

                <!-- Блок файлов с иконками и количеством знаков -->
                <div style="border-top: 1px solid #e2e8f0; padding-top: 12px; display: flex; flex-direction: column; gap: 10px;">
                    <div style="font-weight: 600; color: #334155; font-size: 13px;">Файлы по заказу:</div>
                    
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

                        <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 12px; border-radius: 6px; gap: 15px; flex-wrap: wrap;">
                            <!-- Оригинал -->
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #64748b; font-size: 13px;">Оригинал:</span>
                                @if($file->original_file_path)
                                    <img src="{{ asset('images/file-icons/' . $getIcon($origExt)) }}" style="width: 20px; height: 20px;">
                                    <a href="{{ Storage::url($file->original_file_path) }}" target="_blank" style="color: #3b82f6; text-decoration: none; font-weight: 500;" title="{{ $origFileName }}">
                                        {{ Str::limit($origFileName, 25) }}
                                    </a>
                                @else
                                    <span style="color: #94a3b8; font-size: 13px;">Отсутствует</span>
                                @endif
                                <span style="color: #64748b; font-size: 12px;">({{ $file->original_chars_count ?? 0 }} зн.)</span>
                            </div>

                            <!-- Готовый перевод -->
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #64748b; font-size: 13px;">Перевод:</span>
                                @if($file->translated_file_path)
                                    <img src="{{ asset('images/file-icons/' . $getIcon($transExt)) }}" style="width: 20px; height: 20px;">
                                    <a href="{{ Storage::url($file->translated_file_path) }}" target="_blank" style="color: #10b981; text-decoration: none; font-weight: 600;" title="{{ $transFileName }}">
                                        {{ Str::limit($transFileName, 25) }}
                                    </a>
                                    <span style="color: #64748b; font-size: 12px;">({{ $file->translated_chars_count ?? 0 }} зн.)</span>
                                @else
                                    <span style="color: #94a3b8; font-style: italic; font-size: 13px;">Еще не загружен</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; text-align: center; color: #64748b;">
                У вас пока нет активных заказов.
            </div>
        @endforelse
    </div>

</div>
@endsection