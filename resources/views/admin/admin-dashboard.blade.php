@extends('layouts.app')

@section('content')
<div class="dashboard-container">

    <!-- Карточки метрик (в стиле Nova Cards) -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-title">всего клиентов</div>
            <div class="metric-value">{{ $metrics['total_clients'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">активные дела</div>
            <div class="metric-value">{{ $metrics['active_cases'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">завершенные задачи</div>
            <div class="metric-value">{{ $metrics['completed_tasks'] }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-title">общий оборот</div>
            <div class="metric-value">{{ $metrics['revenue'] }}</div>
        </div>
    </div>

    <!-- Таблица последних записей (в стиле Nova Resource Index) -->
    <div class="nova-card-table">
        <div class="table-header">последние судебные и юридические дела</div>
        <table class="nova-table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>название дела</th>
                    <th>клиент</th>
                    <th>статус</th>
                    <th>дата</th>
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