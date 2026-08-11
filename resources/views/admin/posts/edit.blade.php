@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 16px; margin-bottom: 0; font-weight: 600; font-family: 'Inter', sans-serif;">Редактирование поста</div>
        <a href="{{ route('admin.posts.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: auto; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
    </div>

    <div class="nova-card-table" style="padding: 25px; box-shadow: none; border: 1px solid #e2e8f0; border-radius: 6px; background: #ffffff;">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
                    <div style="font-weight: 600; margin-bottom: 5px;">Обнаружены ошибки:</div>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Название поста</label>
                <input type="text" name="title" class="nova-input" value="{{ old('title', $post->title) }}" placeholder="Введите название" style="width: 100%; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Ярлык (необязательно)</label>
                <input type="text" name="slug" class="nova-input" value="{{ old('slug', $post->slug) }}" placeholder="post-slug" style="width: 100%; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Описание</label>
                <textarea name="description" class="nova-input" placeholder="Описание поста..." style="width: 100%; height: 100px; resize: vertical; box-sizing: border-box;">{{ old('description', $post->description) }}</textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Категория</label>
                <select name="category_id" class="nova-input" style="width: 100%; box-sizing: border-box;" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Теги (удерживайте Ctrl или Cmd для выбора нескольких)</label>
                <select name="tags[]" class="nova-input" multiple style="width: 100%; height: 120px; box-sizing: border-box; padding: 8px;">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ (is_array(old('tags', $post->tags->pluck('id')->toArray())) && in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray()))) ? 'selected' : '' }}>
                            {{ $tag->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Текст поста с ID для подключения CKEditor -->
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Текст поста</label>
                <textarea name="content" id="editor" class="nova-input" placeholder="Текст поста..." style="width: 100%; height: 250px; box-sizing: border-box;" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Изображение поста</label>
                @if($post->thumbnail)
                    <div style="margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" style="max-width: 200px; display: block; border-radius: 4px; border: 1px solid #e2e8f0; margin-bottom: 5px;">
                        <span style="font-size: 12px; color: #475569; display: block; font-weight: 500;">
                            Файл: {{ $post->thumbnail_original_name ?? basename($post->thumbnail) }}
                        </span>
                    </div>
                @endif
                <input type="file" name="thumbnail" class="nova-input" style="width: 100%; box-sizing: border-box;">
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; width: auto; padding: 10px 24px; border: none; border-radius: 4px; font-size: 14px;">Обновить пост</button>
            </div>
        </form>
    </div>

</div>

<!-- Скрипт инициализации CKEditor с автозагрузкой картинок -->
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            language: 'ru',
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'
            ],
            // Обязательный блок конфигурации для работы загрузки
            simpleUpload: {
                uploadUrl: '{{ route('admin.posts.upload-image') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection