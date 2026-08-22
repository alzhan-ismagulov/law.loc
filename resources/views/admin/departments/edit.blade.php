@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 600px;">
    
    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">Редактирование подразделения</div>

    <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Название подразделения</label>
            <input type="text" name="name" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required value="{{ old('name', $department->name) }}">
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Сохранить</button>
            <a href="{{ route('admin.departments.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; display: inline-block; text-align: center;">Отмена</a>
        </div>
    </form>
</div>
@endsection