@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 16px; margin-bottom: 0; font-weight: 600; font-family: 'Inter', sans-serif;">Редактирование: {{ $translator->name }}</div>
        <a href="{{ route('admin.translators.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
    </div>

    <div class="nova-card-table" style="padding: 25px; border: 1px solid #e2e8f0; background: #ffffff;">
        <form action="{{ route('admin.translators.update', $translator->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">ФИО переводчика</label>
                <input type="text" name="name" class="nova-input" value="{{ old('name', $translator->name) }}" style="width: 100%; box-sizing: border-box;" required>
            </div>

            <div style="display: flex; gap: 20px;">
                <div style="margin-bottom: 20px; flex: 1;">
                    <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Фотография</label>
                    @if($translator->photo_path)
                        <img src="{{ asset('storage/' . $translator->photo_path) }}" style="width: 40px; height: 40px; border-radius: 50%; margin-bottom: 5px;">
                    @endif
                    <input type="file" name="photo" class="nova-input" accept="image/*" style="width: 100%; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 20px; flex: 1;">
                    <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Диплом</label>
                    @if($translator->diploma_path)
                        <div style="margin-bottom: 5px;"><a href="{{ asset('storage/' . $translator->diploma_path) }}" target="_blank" style="font-size: 12px; color: #3b82f6;">Посмотреть файл</a></div>
                    @endif
                    <input type="file" name="diploma" class="nova-input" accept=".pdf,.jpg,.png" style="width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Регион</label>
                <select name="region_id" class="nova-input" style="width: 100%;" required>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id', $translator->region_id) == $region->id ? 'selected' : '' }}>{{ $region->title }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #64748b; font-size: 14px;">Статус</label>
                <select name="status" class="nova-input" style="width: 100%;" required>
                    <option value="active" {{ $translator->status == 'active' ? 'selected' : '' }}>Работает</option>
                    <option value="inactive" {{ $translator->status == 'inactive' ? 'selected' : '' }}>Не работает</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 10px 24px; border: none; border-radius: 4px;">Обновить данные</button>
            </div>
        </form>
    </div>
</div>
@endsection