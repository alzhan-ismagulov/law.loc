@extends('layouts.app')

@section('content')
<div class="dashboard-container">

    <!-- Карточки метрик -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-title">Всего клиентов</div>
            <div class="metric-value">{{ $metrics['total_clients'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">Активные дела</div>
            <div class="metric-value">{{ $metrics['active_cases'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">Завершенные задачи</div>
            <div class="metric-value">{{ $metrics['completed_tasks'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">Общий оборот</div>
            <div class="metric-value">{{ $metrics['revenue'] }}</div>
        </div>
    </div>

    <!-- Таблица последних записей -->
    <div class="nova-card-table">
        <div class="table-header">Последние судебные и юридические дела</div>
        <table class="nova-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название дела</th>
                    <th>Клиент</th>
                    <th>Статус</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCases as $case)
                <tr>
                    <td>{{ $case['id'] }}</td>
                    <td>{{ $case['title'] }}</td>
                    <td>{{ $case['client'] }}</td>
                    <td>{{ $case['status'] }}</td>
                    <td>{{ $case['date'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection