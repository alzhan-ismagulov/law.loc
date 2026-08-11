@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 16px; margin-bottom: 0; font-weight: 600; font-family: 'Inter', sans-serif;">Добавление категории</div>
        <a href="{{ route('admin.categories.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: auto; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
    </div>

    <div class="nova-card-table" style="padding: 25px; box-shadow: none; border: 1px solid #e2e8f0; border-radius: 6px; background: #ffffff;">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Название категории</label>
                <input type="text" name="title" class="nova-input" value="{{ old('title') }}" placeholder="Введите название" style="width: 100%; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Слаг (необязательно)</label>
                <input type="text" name="slug" class="nova-input" value="{{ old('slug') }}" placeholder="category-slug" style="width: 100%; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Описание</label>
                <textarea name="description" class="nova-input" placeholder="Описание категории..." style="width: 100%; height: 100px; resize: vertical; box-sizing: border-box;">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; width: auto; padding: 10px 24px; border: none; border-radius: 4px; font-size: 14px;">Создать категорию</button>
            </div>
        </form>
    </div>

</div>
@endsection