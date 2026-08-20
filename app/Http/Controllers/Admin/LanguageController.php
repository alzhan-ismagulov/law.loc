<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('title', 'asc')->paginate(20);
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:languages,title',
        ]);

        Language::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('admin.languages.index')->with('success', 'Язык успешно добавлен.');
    }

    public function show(Language $language)
    {
        return redirect()->route('admin.languages.index');
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:languages,title,' . $language->id,
        ]);

        $language->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('admin.languages.index')->with('success', 'Язык успешно обновлен.');
    }

    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->route('admin.languages.index')->with('success', 'Язык успешно удален.');
    }
}