@extends('client.layouts.app')

@section('content')
<div class="nova-card-table" style="max-width: 800px; padding: 30px;">
    
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

    <form action="{{ route('client.profile') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Имя / Название</label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Email (не меняется)</label>
                <input type="email" value="{{ $client->email }}" class="nova-input" style="width: 100%; padding: 8px; background: #f8fafc; color: #94a3b8;" disabled>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Телефон</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Город</label>
                <input type="text" name="city" value="{{ old('city', $client->city) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Адрес</label>
                <input type="text" name="address" value="{{ old('address', $client->address) }}" class="nova-input" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">Банк</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $client->bank_name) }}" class="nova-input" style="width: 100%; padding: 8px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 5px; color: #64748b;">IBAN</label>
                <input type="text" name="iban" value="{{ old('iban', $client->iban) }}" class="nova-input" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 10px; font-size: 14px; color: #0f172a;">Безопасность (смена пароля)</div>
            <div style="display: grid; grid-template-columns: 1fr 1px; gap: 15px; font-size: 14px;">
                <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; color: #64748b; font-size: 13px;">Новый пароль</label>
                        <input type="password" name="password" class="nova-input" style="width: 100%; padding: 8px;" placeholder="Оставьте пустым">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; color: #64748b; font-size: 13px;">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" class="nova-input" style="width: 100%; padding: 8px;" placeholder="Повторите пароль">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Сохранить изменения</button>
    </form>
</div>
@endsection