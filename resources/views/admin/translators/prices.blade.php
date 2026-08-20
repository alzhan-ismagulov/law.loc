@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    <div class="table-header" style="margin-bottom: 20px;">Мои языковые пары и тарифы</div>

    @forelse($translator->languagePairs as $pair)
        @php 
            $latestPrice = $pair->prices()->orderBy('effective_from', 'desc')->orderBy('id', 'desc')->first();
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
        <div style="font-size: 14px; color: #64748b;">У вас пока нет добавленных языковых пар.</div>
    @endforelse
</div>
@endsection