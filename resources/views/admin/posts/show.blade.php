@extends('layouts.app')

@section('content')
<div style="min-width: 600px; margin: 5px auto; padding: 0 10px; font-family: 'Inter', sans-serif; color: #1e293b;">
    
    <!-- Навигация назад -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.posts.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
            <span>←</span> Назад к списку постов
        </a>
    </div>

    <!-- Основной макет статьи (сетка: контент + сайдбар детализации) -->
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 40px; align-items: start;" class="article-grid">
        
        <!-- Левая колонка: Сам материал -->
        <main style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            
            <!-- Хлебные крошки / Категория -->
            @if($post->category)
                <div style="margin-bottom: 15px;">
                    <span style="background-color: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $post->category->title }}
                    </span>
                </div>
            @endif

            <!-- Заголовок -->
            <h1 style="font-size: 32px; line-height: 1.3; font-weight: 700; color: #0f172a; margin: 0 0 20px 0;">
                {{ $post->title }}
            </h1>

            <!-- Краткое описание / Лид -->
            @if($post->description)
                <p style="font-size: 18px; line-height: 1.6; color: #475569; margin: 0 0 25px 0; font-weight: 400;">
                    {{ $post->description }}
                </p>
            @endif

            <!-- Главное изображение -->
            @if($post->thumbnail)
                <div style="margin-bottom: 30px;">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 6px; display: block;">
                    @if($post->thumbnail_original_name)
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 6px; text-align: right;">
                            Файл: {{ $post->thumbnail_original_name }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Текст статьи (вывод HTML из CKEditor 5) -->
            <div style="font-size: 16px; line-height: 1.8; color: #334155; word-break: break-word; font-family: Georgia, serif;" class="ck-content">
                {!! $post->content !!}
            </div>

            <!-- Теги внизу статьи -->
            @if($post->tags->count() > 0)
                <div style="border-top: 1px solid #e2e8f0; margin-top: 40px; padding-top: 20px; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; margin-right: 5px;">Теги:</span>
                    @foreach($post->tags as $tag)
                        <span style="background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                            #{{ $tag->title }}
                        </span>
                    @endforeach
                </div>
            @endif

        </main>

        <!-- Правая колонка: Карточка информации / Сайдбар -->
        <aside style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Блок метаданных -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <h3 style="font-size: 15px; font-weight: 600; color: #0f172a; margin: 0 0 15px 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                    Информация о материале
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: #64748b;">
                    <div>
                        <span style="display: block; color: #94a3b8; font-size: 11px; text-transform: uppercase; margin-bottom: 2px;">Создано</span>
                        <span style="color: #1e293b; font-weight: 500;">{{ $post->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    @if($post->updated_at != $post->created_at)
                        <div>
                            <span style="display: block; color: #94a3b8; font-size: 11px; text-transform: uppercase; margin-bottom: 2px;">Обновлено</span>
                            <span style="color: #1e293b; font-weight: 500;">{{ $post->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    @endif

                    <div>
                        <span style="display: block; color: #94a3b8; font-size: 11px; text-transform: uppercase; margin-bottom: 2px;">Просмотры</span>
                        <span style="color: #1e293b; font-weight: 500;">{{ $post->views }}</span>
                    </div>

                    @if($post->category)
                        <div>
                            <span style="display: block; color: #94a3b8; font-size: 11px; text-transform: uppercase; margin-bottom: 2px;">Категория</span>
                            <span style="color: #2563eb; font-weight: 500;">{{ $post->category->title }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Блок быстрых действий (например, редактирование) -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; display: flex; gap: 10px;">
                <a href="{{ route('admin.posts.edit', $post->id) }}" style="flex: 1; text-align: center; background-color: #3b82f6; color: #fff; padding: 10px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">
                    Изменить
                </a>
            </div>

        </aside>

    </div>
</div>

<!-- Адаптивность для мобильных экранов -->
<style>
@media (max-width: 768px) {
    .article-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection