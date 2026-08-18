<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'tags'])->latest()->paginate(10);
        
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'views' => 'nullable|integer|min:0',
            'thumbnail_original_name' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;

            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;
            $validated['views'] = 0;

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;

                $validated['thumbnail_original_name'] = $file->getClientOriginalName();
                $validated['thumbnail'] = $file->storeAs('thumbnails', $fileName, 'public');
            }

            $post = Post::create($validated);

            if ($request->has('tags')) {
                $post->tags()->sync($request->tags);
            }

            DB::commit();

            return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store post error: ' . $e->getMessage());

            if (isset($validated['thumbnail'])) {
                Storage::disk('public')->delete($validated['thumbnail']);
            }

            return back()->withInput()->withErrors(['error' => 'Ошибка при создании: ' . $e->getMessage()]);
        }
    }

    public function show(Post $post)
    {
        $post->increment('views');
        
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;

            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $validated['slug'] = $slug;

            $oldThumbnail = $post->thumbnail;
            $newThumbnail = null;

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . rand(1000, 9999) . '.' . $extension;

                $newThumbnail = $file->storeAs('thumbnails', $fileName, 'public');
                $validated['thumbnail_original_name'] = $file->getClientOriginalName();
                $validated['thumbnail'] = $newThumbnail;
            }

            // Обновляем запись в базе
            $post->update($validated);

            // Удаляем старый файл после успешного сохранения нового
            if ($newThumbnail && $oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            $post->tags()->sync($request->input('tags', []));

            DB::commit();

            return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update post error: ' . $e->getMessage());

            if (isset($newThumbnail)) {
                Storage::disk('public')->delete($newThumbnail);
            }

            return back()->withInput()->withErrors(['error' => 'Ошибка при обновлении: ' . $e->getMessage()]);
        }
    }

    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();

            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            $post->tags()->detach();
            $post->delete();

            DB::commit();

            return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete post error: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Ошибка при удалении: ' . $e->getMessage()]);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $extension = $file->getClientOriginalExtension();
                $fileName = 'editor_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
                
                $path = $file->storeAs('posts', $fileName, 'public');

                // Обязательный формат ответа для CKEditor 5
                return response()->json([
                    'url' => asset('storage/' . $path)
                ]);
            }

            return response()->json([
                'error' => [
                    'message' => 'Файл не был переданы в запросе.'
                ]
            ], 400);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Editor image upload error: ' . $e->getMessage());
            
            return response()->json([
                'error' => [
                    'message' => 'Ошибка сервера: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
}