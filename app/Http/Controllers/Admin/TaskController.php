<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Сохранение новой задачи с файлами
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'legal_case_id' => 'nullable|exists:legal_cases,id',
            'executor_id' => 'required|exists:employees,id',
            'due_date' => 'nullable|date',
            'documents.*' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,xlsx|max:10240', // до 10 МБ
        ]);

        $documentsPaths = [];

        // Обработка загрузки файлов
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('tasks_docs', 'public');
                $documentsPaths[] = $path;
            }
        }

        Task::create([
            'tenant_id' => 1, // Здесь будет определяться текущий тенант пользователя
            'legal_case_id' => $validated['legal_case_id'] ?? null,
            'creator_id' => 1, // ID авторизованного сотрудника-руководителя
            'executor_id' => $validated['executor_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'status' => 'pending',
            'documents' => $documentsPaths,
        ]);

        return redirect()->back();
    }

    // Изменение статуса задачи (например, выполнено)
    public function updateStatus(Request $request, Task $task)
    {
        $task->update([
            'status' => $request->input('status', 'in_progress'),
        ]);

        return redirect()->back();
    }
}