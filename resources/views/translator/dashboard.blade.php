@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    <div class="table-header" style="margin-bottom: 20px;">Добро пожаловать, {{ $translator->name }}!</div>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
        <div class="metric-card" style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div class="metric-title" style="color: #64748b; margin-bottom: 8px;">Активных заказов</div>
            <div class="metric-value" style="font-size: 24px; color: #0f172a;">0</div>
        </div>
        <div class="metric-card" style="background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px;">
            <div class="metric-title" style="color: #64748b; margin-bottom: 8px;">Языковых пар</div>
            <div class="metric-value" style="font-size: 24px; color: #0f172a;">{{ $translator->languagePairs->count() }}</div>
        </div>
    </div>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; font-size: 14px; color: #334155;">
        Используйте боковое меню для управления своими тарифами, просмотра заказов и редактирования личных данных.
    </div>
</div>
@endsection