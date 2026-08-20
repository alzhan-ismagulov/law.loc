@extends('translator.layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-header" style="margin-bottom: 20px;">Мой профиль и настройки</div>

    <form action="{{ route('translator.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Личные данные</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Имя</label>
                    <input type="text" name="name" value="{{ old('name', $translator->name) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Email (не меняется)</label>
                    <input type="email" value="{{ $translator->email }}" class="nova-input" style="width: 100%; padding: 8px; background: #f8fafc; color: #94a3b8;" disabled>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Телефон</label>
                    <input type="text" name="phone" value="{{ old('phone', $translator->phone) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Страна</label>
                    <input type="text" name="country" value="{{ old('country', $translator->country) }}" class="nova-input" style="width: 100% ; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Город</label>
                    <input type="text" name="city" value="{{ old('city', $translator->city) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Банковские реквизиты</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Банк</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $translator->bank_name) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">IBAN</label>
                    <input type="text" name="iban" value="{{ old('iban', $translator->iban) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Номер карты</label>
                    <input type="text" name="card_number" value="{{ old('card_number', $translator->card_number) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Тип карты</label>
                    <input type="text" name="card_type" value="{{ old('card_type', $translator->card_type) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
            </div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Безопасность (смена пароля)</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Новый пароль</label>
                    <input type="password" name="password" class="nova-input" style="width: 100%; padding: 8px;" placeholder="Оставьте пустым, если не нужно менять">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" class="nova-input" style="width: 100%; padding: 8px;" placeholder="Повторите новый пароль">
                </div>
            </div>
        </div>

        <button type="submit" class="nova-input" style="background: #3b82f6; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-size: 14px;">Сохранить изменения</button>
    </form>
</div>
@endsection