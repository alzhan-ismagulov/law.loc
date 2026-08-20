@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 16px; font-weight: 600;">Создание переводчика</div>
        <a href="{{ route('admin.translators.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад</a>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.translators.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- БЛОК 1: Основная информация -->
        <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px;">Основная информация</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <input type="text" name="name" class="nova-input" placeholder="ФИО переводчика" value="{{ old('name') }}" required>
                
                <select name="country" id="countrySelect" class="nova-input" onchange="toggleRegions()" required>
                    @foreach($countries as $country)
                        <option value="{{ $country->title }}" {{ old('country', 'Казахстан') == $country->title ? 'selected' : '' }}>{{ $country->title }}</option>
                    @endforeach
                </select>

                <!-- Обертка для динамического скрытия регионов -->
                <div id="regionContainer">
                    <select name="region_id" class="nova-input" style="width: 100%;">
                        <option value="">Выберите регион</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id') == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="text" name="city" class="nova-input" placeholder="Город" value="{{ old('city') }}" required>
                
                <!-- Адрес перенесен наверх -->
                <input type="text" name="address" class="nova-input" placeholder="Адрес" value="{{ old('address') }}">
                
                <!-- Телефон с маской -->
                <input type="text" name="phone" id="phoneInput" class="nova-input" placeholder="+7 (777) 123-45-67" value="{{ old('phone') }}" required>
                
                <input type="email" name="email" class="nova-input" placeholder="Email" value="" required>
                
                <!-- Пароль для входа -->
                <input type="password" name="password" class="nova-input" placeholder="Пароль для входа" required>

                <div>
                    <label style="font-size: 12px; color: #64748b;">Фотография:</label>
                    <input type="file" name="photo" class="nova-input" accept="image/*">
                </div>
            </div>
            <textarea name="internal_notes" class="nova-input" placeholder="Внутренние заметки" style="width: 100%; margin-top: 15px; height: 80px;">{{ old('internal_notes') }}</textarea>
        </div>

        <!-- БЛОК 2: Реквизиты и документы -->
        <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px;">Реквизиты и документы</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Номер карты с исправленным плейсхолдером -->
                <input type="text" name="card_number" id="cardInput" class="nova-input" placeholder="Номер карты" value="{{ old('card_number') }}">
                
                <input type="text" name="card_type" class="nova-input" placeholder="Тип карты (Visa/MasterCard)" value="{{ old('card_type') }}">
                <input type="text" name="bank_name" class="nova-input" placeholder="Банк" value="{{ old('bank_name') }}">
                
                <!-- IBAN ограничение в 20 символов -->
                <input type="text" name="iban" class="nova-input" placeholder="IBAN (20 символов)" maxlength="20" value="{{ old('iban') }}">
                
                <div>
                    <label style="font-size: 12px; color: #64748b;">Файл диплома:</label>
                    <input type="file" name="diploma" class="nova-input" accept=".pdf,.jpg,.png">
                </div>
                
                <select name="status" class="nova-input">
                    <option value="active">Работает</option>
                    <option value="inactive">Не работает</option>
                </select>
            </div>
        </div>

        <!-- БЛОК 3: Специализация и тарифы (Динамический) -->
        <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <div style="font-weight: 600; margin-bottom: 15px;">Языковые пары и тарифы</div>
            <div id="language-pairs-container">
                <!-- Сюда JS будет добавлять новые пары -->
            </div>
            <button type="button" onclick="addLanguagePair()" class="nova-input" style="background: #f1f5f9; border: none; cursor: pointer; padding: 8px 16px;">+ Добавить языковую пару</button>
        </div>

        <button type="submit" class="nova-input" style="background: #3b82f6; color: white; width: 100%; padding: 15px; border: none; cursor: pointer;">Сохранить переводчика</button>
    </form>
</div>

<script>
let pairIndex = 0;

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

// Маска для номера карты (4 блока по 4 цифры)
document.getElementById('cardInput').addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '').substring(0, 16);
    e.target.value = v != '' ? v.match(/.{1,4}/g).join(' ') : '';
});

function addLanguagePair() {
    const container = document.getElementById('language-pairs-container');
    const html = `
    <div style="border: 1px solid #e2e8f0; padding: 15px; margin-bottom: 15px; border-radius: 6px; background: #f8fafc; box-sizing: border-box;">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
            <select name="pairs[${pairIndex}][source]" class="nova-input" required style="flex: 1; min-width: 140px; box-sizing: border-box;">
                <option value="">Исходный язык</option>
                @foreach($languages as $l)
                    <option value="{{ $l->id }}">{{ $l->title }}</option>
                @endforeach
            </select>
            <select name="pairs[${pairIndex}][target]" class="nova-input" required style="flex: 1; min-width: 140px; box-sizing: border-box;">
                <option value="">Целевой язык</option>
                @foreach($languages as $l)
                    <option value="{{ $l->id }}">{{ $l->title }}</option>
                @endforeach
            </select>
            <select name="pairs[${pairIndex}][currency]" class="nova-input" style="width: 140px; box-sizing: border-box;" required>
                @foreach($currencies as $c)
                    <option value="{{ $c->code }}">{{ $c->code }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][written_price_1800]" class="nova-input" placeholder="За 1800 знаков с пробелами" style="box-sizing: border-box;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][consecutive_price_hour]" class="nova-input" placeholder="Устный перевод/час" style="box-sizing: border-box;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][simultaneous_price_hour]" class="nova-input" placeholder="Синхронный перевод/час" style="box-sizing: border-box;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][notarial_fee]" class="nova-input" placeholder="За нотариальное заверение" style="box-sizing: border-box;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][editing_price_1800]" class="nova-input" placeholder="За редактуру" style="box-sizing: border-box;">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    pairIndex++;
}

document.addEventListener("DOMContentLoaded", function() {
    toggleRegions();
    addLanguagePair();
});
</script>
@endsection