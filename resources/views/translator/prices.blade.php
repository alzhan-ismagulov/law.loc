@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-header" style="margin-bottom: 20px;">Мои языковые пары и тарифы</div>

    @forelse($translator->languagePairs as $pair)
        @php 
            $latestPrice = $pair->prices()->orderBy('effective_from', 'desc')->orderBy('id', 'desc')->first();
            $allPrices = $pair->prices()->orderBy('effective_from', 'desc')->orderBy('id', 'desc')->get();
        @endphp
        <div style="border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 20px; background: #f8fafc; font-size: 14px;">
            <div style="font-weight: 600; margin-bottom: 15px; color: #0f172a; font-size: 16px;">
                {{ $pair->sourceLanguage->title ?? '?' }} &rarr; {{ $pair->targetLanguage->title ?? '?' }}
            </div>

            <!-- Форма обновления цены для пары -->
            <form action="{{ route('translator.prices.update', $pair->id) }}" method="POST" style="margin-bottom: 20px; background: #ffffff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 6px;">
                @csrf
                @method('PUT')
                <div style="font-weight: 500; margin-bottom: 10px; font-size: 14px; color: #334155;">Установить новый тариф</div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 15px;">
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Валюта</label>
                        <select name="currency" class="nova-input" style="width: 100%; padding: 6px; background: #ffffff;">
                            <option value="KZT" {{ (optional($latestPrice)->currency ?? 'KZT') == 'KZT' ? 'selected' : '' }}>KZT</option>
                            <option value="USD" {{ optional($latestPrice)->currency == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ optional($latestPrice)->currency == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="RUB" {{ optional($latestPrice)->currency == 'RUB' ? 'selected' : '' }}>RUB</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Письм. 1800 знаков</label>
                        <input type="number" step="0.01" name="written_price_1800" value="{{ $latestPrice->written_price_1800 ?? '' }}" class="nova-input" style="width: 100%; padding: 6px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Устный час</label>
                        <input type="number" step="0.01" name="consecutive_price_hour" value="{{ $latestPrice->consecutive_price_hour ?? '' }}" class="nova-input" style="width: 100%; padding: 6px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Синхронный час</label>
                        <input type="number" step="0.01" name="simultaneous_price_hour" value="{{ $latestPrice->simultaneous_price_hour ?? '' }}" class="nova-input" style="width: 100%; padding: 6px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Нотариус</label>
                        <input type="number" step="0.01" name="notarial_fee" value="{{ $latestPrice->notarial_fee ?? '' }}" class="nova-input" style="width: 100%; padding: 6px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Редактура 1800</label>
                        <input type="number" step="0.01" name="editing_price_1800" value="{{ $latestPrice->editing_price_1800 ?? '' }}" class="nova-input" style="width: 100%; padding: 6px;">
                    </div>
                </div>
                <input type="hidden" name="effective_from" value="{{ date('Y-m-d') }}">
                <button type="submit" class="nova-input" style="background: #3b82f6; color: white; border: none; padding: 8px 20px; cursor: pointer; border-radius: 4px; font-size: 13px; white-space: nowrap;">Сохранить новый тариф</button>
            </form>

            <!-- История цен -->
            @if($allPrices->count() > 0)
                <div style="font-weight: 500; margin-bottom: 8px; font-size: 13px; color: #64748b;">История изменений тарифов</div>
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
            @endif
        </div>
    @empty
        <div style="font-size: 14px; color: #64748b;">У вас пока нет добавленных языковых пар.</div>
    @endforelse
</div>
@endsection