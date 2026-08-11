<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);

        $recentCases = [
            ['id' => 1, 'title' => 'спор о защите прав потребителей', 'client' => 'анис к.', 'status' => 'в работе', 'date' => '2026-06-06'],
            ['id' => 2, 'title' => 'регистрация юридического лица', 'client' => 'тоо альфа', 'status' => 'завершено', 'date' => '2026-06-05'],
            ['id' => 3, 'title' => 'налоговый аудит и консультация', 'client' => 'ип беков т.', 'status' => 'ожидание', 'date' => '2026-06-04'],
        ];

        return view('admin.categories.index', compact('categories', 'recentCases'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно создана.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно обновлена.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория успешно удалена.');
    }
}