@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="padding: 25px;">
    <div class="table-header" style="margin-bottom: 20px;">Редактирование клиента: {{ $client->name }}</div>
    
    @if($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Блок 1: Основная информация -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">1. Основная информация</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; font-size: 14px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Тип клиента</label>
                    <select name="type" class="nova-input" style="width: 100%; padding: 8px;">
                        <option value="individual" {{ old('type', $client->type) == 'individual' ? 'selected' : '' }}>Физлицо</option>
                        <option value="company" {{ old('type', $client->type) == 'company' ? 'selected' : '' }}>Компания</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Имя / Название компании *</label>
                    <input type="text" name="name" value="{{ old('name', $client->name) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">ИИН / БИН (12 знаков)</label>
                    <input type="text" name="bin_iin" id="binIinInput" maxlength="12" value="{{ old('bin_iin', $client->bin_iin) }}" class="nova-input" style="width: 100%; padding: 8px;" placeholder="12 цифр">
                </div>
            </div>
        </div>

        <!-- Блок 2: Контакты и адрес -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">2. Контакты и адрес</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; font-size: 14px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Email (логин) *</label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Телефон *</label>
                    <input type="text" name="phone" id="phoneInput" value="{{ old('phone', $client->phone) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Страна</label>
                    <select name="country" id="countrySelect" class="nova-input" style="width: 100%; padding: 8px;" onchange="toggleRegions()" required>
                        @foreach($countries as $country)
                            <option value="{{ $country->title }}" {{ old('country', $client->country) == $country->title ? 'selected' : '' }}>{{ $country->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="regionContainer">
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Регион</label>
                    <select name="region_id" class="nova-input" style="width: 100%; padding: 8px;">
                        <option value="">Выберите регион</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id', $client->region_id) == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Город *</label>
                    <input type="text" name="city" value="{{ old('city', $client->city) }}" class="nova-input" style="width: 100%; padding: 8px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Адрес</label>
                    <input type="text" name="address" value="{{ old('address', $client->address) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Контактное лицо (для юрлиц)</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $client->contact_person) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Должность</label>
                    <input type="text" name="position" value="{{ old('position', $client->position) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
            </div>
        </div>

        <!-- Блок 3: CRM и финансовые данные -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">3. CRM и финансовые данные</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; font-size: 14px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Статус</label>
                    <select name="status" class="nova-input" style="width: 100%; padding: 8px;">
                        <option value="active" {{ old('status', $client->status) == 'active' ? 'selected' : '' }}>Активный</option>
                        <option value="lead" {{ old('status', $client->status) == 'lead' ? 'selected' : '' }}>Лид</option>
                        <option value="archive" {{ old('status', $client->status) == 'archive' ? 'selected' : '' }}>Архив</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Источник привлечения</label>
                    <input type="text" name="source" value="{{ old('source', $client->source) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Персональная скидка (%)</label>
                    <input type="number" step="0.01" name="discount_percent" value="{{ old('discount_percent', $client->discount_percent) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Банк</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $client->bank_name) }}" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">IBAN (20 символов)</label>
                    <input type="text" name="iban" id="ibanInput" maxlength="20" value="{{ old('iban', $client->iban) }}" class="nova-input" style="width: 100%; padding: 8px;" placeholder="KZ...">
                </div>
            </div>
        </div>

        <!-- Блок 4: Безопасность и Заметки -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">4. Безопасность и заметки</div>
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px; font-size: 14px;">
                <div style="max-width: 400px;">
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Новый пароль (оставьте пустым)</label>
                    <input type="password" name="password" class="nova-input" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; color: #64748b;">Внутренние заметки</label>
                    <textarea name="internal_notes" class="nova-input" style="width: 100%; padding: 8px; height: 120px;">{{ old('internal_notes', $client->internal_notes) }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Сохранить изменения</button>
    </form>
</div>

<script>
function toggleRegions() {
    const country = document.getElementById('countrySelect').value;
    const container = document.getElementById('regionContainer');
    if (country === 'Казахстан') {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
        container.querySelector('select').value = '';
    }
}

// Маска для телефона (+7 ...)
document.getElementById('phoneInput').addEventListener('input', function (e) {
    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
    if (!x[2]) { e.target.value = '+7'; return; }
    e.target.value = '+7 (' + x[2] + (x[3] ? ') ' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
});

// Маска для ИИН/БИН (только цифры, до 12 символов)
document.getElementById('binIinInput').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 12);
});

// Маска для IBAN (только заглавные латинские буквы и цифры, до 20 символов)
document.getElementById('ibanInput').addEventListener('input', function (e) {
    e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 20);
});

document.addEventListener("DOMContentLoaded", function() {
    toggleRegions();
});
</script>
@endsection