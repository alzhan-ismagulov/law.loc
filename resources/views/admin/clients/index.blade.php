@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="table-header">Клиенты</div>
        <a href="{{ route('admin.clients.create') }}" style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 14px;">+ Добавить клиента</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 4px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px; text-align: left;">Имя / Компания</th>
                <th style="padding: 12px; text-align: left;">Тип</th>
                <th style="padding: 12px; text-align: left;">Телефон</th>
                <th style="padding: 12px; text-align: left;">Email</th>
                <th style="padding: 12px; text-align: left;">Статус</th>
                <th style="padding: 12px; text-align: center;">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            @php
                $statusBg = '#ffffff';
                $statusColor = '#0f172a';
                if ($client->status == 'active') {
                    $statusBg = '#d1fae5';
                    $statusColor = '#065f46';
                } elseif ($client->status == 'lead') {
                    $statusBg = '#ffedd5';
                    $statusColor = '#9a3412';
                } elseif ($client->status == 'archive') {
                    $statusBg = '#f1f5f9';
                    $statusColor = '#475569';
                }
            @endphp
            <tr style="border-bottom: 1px solid #e2e8f0; cursor: pointer; transition: background 0.15s;" 
                onmouseover="this.style.background='#f8fafc'" 
                onmouseout="this.style.background='transparent'"
                onclick="window.location='{{ route('admin.clients.edit', $client->id) }}'">
                
                <td style="padding: 12px; font-weight: 500;">{{ $client->name }}</td>
                <td style="padding: 12px;">{{ $client->type == 'company' ? 'Компания' : 'Физлицо' }}</td>
                <td style="padding: 12px;">{{ $client->phone }}</td>
                <td style="padding: 12px;">{{ $client->email }}</td>
                <td style="padding: 12px;">
                    <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; display: inline-block;">
                        @if($client->status == 'active') Активный
                        @elseif($client->status == 'lead') Лид
                        @elseif($client->status == 'archive') Архив
                        @else {{ $client->status }}
                        @endif
                    </span>
                </td>
                <td style="padding: 12px; text-align: center;" onclick="event.stopPropagation();">
                    <a href="{{ route('admin.clients.edit', $client->id) }}" style="color: #3b82f6; text-decoration: none; margin-right: 10px;">Ред.</a>
                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;" onclick="return confirm('Удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection