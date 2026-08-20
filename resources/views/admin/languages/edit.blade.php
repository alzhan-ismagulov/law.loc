@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 600px;">
    <div class="table-header" style="margin-bottom: 20px;">Редактировать язык</div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.languages.update', $language->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #0f172a;">Название языка</label>
            <input type="text" name="title" value="{{ old('title', $language->title) }}" class="nova-input" style="width: 100%;" required>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('admin.languages.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border: none; display: inline-block;">Отмена</a>
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 16px; border: none;">Обновить</button>
        </div>
    </form>
</div>
@endsection