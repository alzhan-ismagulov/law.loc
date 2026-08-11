<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tags,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Тег успешно создан.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . $tag->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Тег успешно обновлен.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Тег успешно удален.');
    }
}