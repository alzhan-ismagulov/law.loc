@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 25px;">

    <!-- Шапка карточки -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 18px; font-weight: 600;">Карточка переводчика: {{ $translator->name }}</div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.translators.edit', $translator->id) }}" class="nova-input" style="background-color: #3b82f6; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Редактировать</a>
            <a href="{{ route('admin.translators.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <!-- Табы переключения -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
        <button type="button" onclick="switchTab('main')" id="btnTabMain" class="nova-input" style="background: #3b82f6; color: white; border: none; cursor: pointer; padding: 8px 16px; border-radius: 4px;">Общая информация</button>
        <button type="button" onclick="switchTab('prices')" id="btnTabPrices" class="nova-input" style="background: #e2e8f0; color: #0f172a; border: none; cursor: pointer; padding: 8px 16px; border-radius: 4px;">Языковые пары и тарифы</button>
    </div>

    <!-- ТАБ 1: Общая информация и реквизиты -->
    <div id="tabMain" class="tab-content">
        <!-- БЛОК 1: Основная информация с фото -->
        <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 6px; background: #ffffff;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Основная информация</div>
            
            <div style="display: flex; gap: 20px; align-items: flex-start; margin-bottom: 15px;">
                <div>
                    @if($translator->photo_path)
                        <img src="{{ asset('storage/' . $translator->photo_path) }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;" alt="Фото">
                    @else
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; border: 2px solid #e2e8f0;">Нет фото</div>
                    @endif
                </div>

                <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                    <div><strong>Страна:</strong> {{ $translator->country }}</div>
                    <div><strong>Город:</strong> {{ $translator->city }}</div>
                    <div><strong>Адрес:</strong> {{ $translator->address ?? 'Не указан' }}</div>
                    <div><strong>Телефон:</strong> {{ $translator->phone }}</div>
                    <div><strong>Email:</strong> {{ $translator->email }}</div>
                    <div><strong>Статус:</strong> 
                        <span style="padding: 2px 8px; border-radius: 4px; font-size: 12px; background: {{ $translator->status == 'active' ? '#d1fae5' : '#f1f5f9' }}; color: {{ $translator->status == 'active' ? '#065f46' : '#64748b' }};">
                            {{ $translator->status == 'active' ? 'Работает' : 'Не работает' }}
                        </span>
                    </div>
                </div>
            </div>

            @if($translator->internal_notes)
                <div style="margin-top: 15px; font-size: 14px; background: #f8fafc; padding: 10px; border-radius: 4px;">
                    <strong>Внутренние заметки:</strong> {{ $translator->internal_notes }}
                </div>
            @endif
        </div>

        <!-- БЛОК 2: Реквизиты и документы -->
        <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 6px; background: #ffffff;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Реквизиты и документы</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                <div><strong>Номер карты:</strong> {{ $translator->card_number ?? 'Не указан' }}</div>
                <div><strong>Тип карты:</strong> {{ $translator->card_type ?? 'Не указан' }}</div>
                <div><strong>Банк:</strong> {{ $translator->bank_name ?? 'Не указан' }}</div>
                <div><strong>IBAN:</strong> {{ $translator->iban ?? 'Не указан' }}</div>
                <div><strong>Диплом:</strong> 
                    @if($translator->diploma_path)
                        <a href="{{ asset('storage/' . $translator->diploma_path) }}" target="_blank" style="color: #3b82f6;">Скачать / Посмотреть</a>
                    @else
                        Не загружен
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- БЛОК 3: Языковые пары и история тарифов -->
    <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px; background: #ffffff;">
        <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Языковые пары и история тарифов</div>
        
        @forelse($translator->languagePairs as $pair)
            @php 
                $latestPrice = $pair->prices()->orderBy('effective_from', 'desc')->orderBy('id', 'desc')->first();
                // Получаем все записи истории тарифов по этой паре
                $allPrices = $pair->prices()->orderBy('effective_from', 'desc')->orderBy('id', 'desc')->get();
            @endphp
            <div style="border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-bottom: 15px; background: #f8fafc; font-size: 14px;">
                <div style="font-weight: 600; margin-bottom: 10px; color: #0f172a; font-size: 15px;">
                    {{ $pair->sourceLanguage->title ?? '?' }} &rarr; {{ $pair->targetLanguage->title ?? '?' }}
                </div>

                @if($allPrices->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; font-size: 12px; border-collapse: collapse; background: #ffffff;">
                            <thead>
                                <tr style="background: #f1f5f9; text-align: left; color: #475569;">
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Статус</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Дата</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Валюта</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Письм. 1800</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Устный час</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Синхрон</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Нотариус</th>
                                    <th style="padding: 6px; border: 1px solid #e2e8f0;">Редактура</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allPrices as $price)
                                    @php 
                                        $isLatest = ($latestPrice && $price->id === $latestPrice->id); 
                                    @endphp
                                    <tr style="background-color: {{ $isLatest ? '#f0fdf4' : '#ffffff' }}; color: {{ $isLatest ? '#166534' : '#64748b' }}; font-weight: {{ $isLatest ? '600' : 'normal' }};">
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">
                                            @if($isLatest)
                                                <span style="background: #dcfce7; color: #166534; padding: 2px 6px; border-radius: 4px; font-size: 10px;">Актуальный</span>
                                            @else
                                                <span style="color: #94a3b8; font-size: 10px;">Архив</span>
                                            @endif
                                        </td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ optional($price->effective_from)->format('d.m.Y') }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->currency }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->written_price_1800 ?? '—' }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->consecutive_price_hour ?? '—' }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->simultaneous_price_hour ?? '—' }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->notarial_fee ?? '—' }}</td>
                                        <td style="padding: 6px; border: 1px solid #e2e8f0;">{{ $price->editing_price_1800 ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="font-size: 13px; color: #94a3b8;">Тарифы не заданы</div>
                @endif
            </div>
        @empty
            <div style="font-size: 14px; color: #64748b;">У переводчика пока нет добавленных языковых пар.</div>
        @endforelse
    </div>

</div>

<script>
function switchTab(tabName) {
    document.getElementById('tabMain').style.display = tabName === 'main' ? 'block' : 'none';
    document.getElementById('tabPrices').style.display = tabName === 'prices' ? 'block' : 'none';
    
    document.getElementById('btnTabMain').style.background = tabName === 'main' ? '#3b82f6' : '#e2e8f0';
    document.getElementById('btnTabMain').style.color = tabName === 'main' ? '#ffffff' : '#0f172a';
    
    document.getElementById('btnTabPrices').style.background = tabName === 'prices' ? '#3b82f6' : '#e2e8f0';
    document.getElementById('btnTabPrices').style.color = tabName === 'prices' ? '#ffffff' : '#0f172a';
}
</script>
@endsection