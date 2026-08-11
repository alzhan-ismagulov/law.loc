<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_clients' => 1245,
            'active_cases' => 84,
            'completed_tasks' => 312,
            'revenue' => '4 520 000 тг',
        ];

        $recentCases = [
            ['id' => 1, 'title' => 'спор о защите прав потребителей', 'client' => 'анис к.', 'status' => 'в работе', 'date' => '2026-06-06'],
            ['id' => 2, 'title' => 'регистрация юридического лица', 'client' => 'тоо альфа', 'status' => 'завершено', 'date' => '2026-06-05'],
            ['id' => 3, 'title' => 'налоговый аудит и консультация', 'client' => 'ип беков т.', 'status' => 'ожидание', 'date' => '2026-06-04'],
        ];

        return view('admin.admin-dashboard', compact('metrics', 'recentCases'));
    }
}