@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="min-width: 600px; margin: 0 auto; padding: 30px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="font-size: 18px; font-weight: 600;">Редактирование переводчика: {{ $translator->name }}</div>
        <a href="{{ route('admin.translators.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px;">Назад к списку</a>
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

    <!-- Табы переключения -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
        <button type="button" onclick="switchTab('main')" id="btnTabMain" class="nova-input" style="background: #3b82f6; color: white; border: none; cursor: pointer; padding: 8px 16px; border-radius: 4px;">Основные данные</button>
        <button type="button" onclick="switchTab('prices')" id="btnTabPrices" class="nova-input" style="background: #e2e8f0; color: #0f172a; border: none; cursor: pointer; padding: 8px 16px; border-radius: 4px;">Языковые пары и тарифы</button>
    </div>

    <form action="{{ route('admin.translators.update', $translator->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ТАБ 1: Основные данные -->
        <div id="tabMain" class="tab-content">
            <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 6px; background: #ffffff;">
                <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Основная информация</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <input type="text" name="name" class="nova-input" placeholder="ФИО переводчика" value="{{ old('name', $translator->name) }}" required>
                    
                    <select name="country" id="countrySelect" class="nova-input" onchange="toggleRegions()" required>
                        @foreach($countries as $country)
                            <option value="{{ $country->title }}" {{ old('country', $translator->country) == $country->title ? 'selected' : '' }}>{{ $country->title }}</option>
                        @endforeach
                    </select>

                    <div id="regionContainer">
                        <select name="region_id" class="nova-input" style="width: 100%;">
                            <option value="">Выберите регион</option>
                            @foreach($regions as $r)
                                <option value="{{ $r->id }}" {{ old('region_id', $translator->region_id) == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="text" name="city" class="nova-input" placeholder="Город" value="{{ old('city', $translator->city) }}" required>
                    <input type="text" name="address" class="nova-input" placeholder="Адрес" value="{{ old('address', $translator->address) }}">
                    <input type="text" name="phone" id="phoneInput" class="nova-input" placeholder="+7 (777) 123-45-67" value="{{ old('phone', $translator->phone) }}" required>
                    <input type="email" name="email" class="nova-input" placeholder="Email" value="{{ old('email', $translator->email) }}" required>
                    <input type="password" name="password" class="nova-input" placeholder="Новый пароль (оставьте пустым)">

                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 5px;">Фотография:</label>
                        @if($translator->photo_path)
                            <div style="margin-bottom: 8px;">
                                <img src="{{ asset('storage/' . $translator->photo_path) }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;" alt="Фото">
                            </div>
                        @endif
                        <input type="file" name="photo" class="nova-input" accept="image/*">
                    </div>
                </div>
                <textarea name="internal_notes" class="nova-input" placeholder="Внутренние заметки" style="width: 100%; margin-top: 15px; height: 80px;">{{ old('internal_notes', $translator->internal_notes) }}</textarea>
            </div>

            <!-- Блок реквизитов -->
            <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 6px; background: #ffffff;">
                <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Реквизиты и документы</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <input type="text" name="card_number" id="cardInput" class="nova-input" placeholder="Номер карты" value="{{ old('card_number', $translator->card_number) }}">
                    <input type="text" name="card_type" class="nova-input" placeholder="Тип карты (Visa/MasterCard)" value="{{ old('card_type', $translator->card_type) }}">
                    <input type="text" name="bank_name" class="nova-input" placeholder="Банк" value="{{ old('bank_name', $translator->bank_name) }}">
                    <input type="text" name="iban" class="nova-input" placeholder="IBAN (20 символов)" maxlength="20" value="{{ old('iban', $translator->iban) }}">
                    
                    <div>
                        <label style="font-size: 12px; color: #64748b; display: block; margin-bottom: 5px;">Файл диплома:</label>
                        @if($translator->diploma_path)
                            <div style="margin-bottom: 5px;"><a href="{{ asset('storage/' . $translator->diploma_path) }}" target="_blank" style="font-size: 12px; color: #3b82f6;">Посмотреть диплом</a></div>
                        @endif
                        <input type="file" name="diploma" class="nova-input" accept=".pdf,.jpg,.png">
                    </div>
                    
                    <select name="status" class="nova-input">
                        <option value="active" {{ old('status', $translator->status) == 'active' ? 'selected' : '' }}>Работает</option>
                        <option value="inactive" {{ old('status', $translator->status) == 'inactive' ? 'selected' : '' }}>Не работает</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ТАБ 2: Языковые пары и тарифы -->
        <div id="tabPrices" class="tab-content" style="display: none;">
            <div class="nova-card-table" style="padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 20px; border-radius: 6px; background: #ffffff;">
                <div style="font-weight: 600; margin-bottom: 15px; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Существующие языковые пары и тарифы</div>
                
                @forelse($translator->languagePairs as $pair)
                    @php 
                        $latestPrice = $pair->prices()->latest('effective_from')->first(); 
                    @endphp
                    <div style="border: 1px solid #cbd5e1; padding: 15px; margin-bottom: 15px; border-radius: 6px; background: #f8fafc;">
                        <input type="hidden" name="existing_pairs[{{ $pair->id }}][id]" value="{{ $pair->id }}">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <strong style="font-size: 15px; color: #0f172a;">{{ $pair->sourceLanguage->title ?? '?' }} &rarr; {{ $pair->targetLanguage->title ?? '?' }}</strong>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <label style="font-size: 12px; color: #64748b;">Дата тарифа:</label>
                                <input type="date" name="existing_pairs[{{ $pair->id }}][effective_from]" class="nova-input" value="{{ optional($latestPrice)->effective_from ? optional($latestPrice)->effective_from->format('Y-m-d') : date('Y-m-d') }}" style="width: 140px;" required>
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <select name="existing_pairs[{{ $pair->id }}][currency]" class="nova-input" style="width: 140px;" required>
                                @foreach($currencies as $c)
                                    <option value="{{ $c->code }}" {{ optional($latestPrice)->currency == $c->code ? 'selected' : '' }}>{{ $c->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
                            <input type="number" step="0.01" name="existing_pairs[{{ $pair->id }}][written_price_1800]" class="nova-input" placeholder="Письм. 1800" value="{{ optional($latestPrice)->written_price_1800 }}">
                            <input type="number" step="0.01" name="existing_pairs[{{ $pair->id }}][consecutive_price_hour]" class="nova-input" placeholder="Устный час" value="{{ optional($latestPrice)->consecutive_price_hour }}">
                            <input type="number" step="0.01" name="existing_pairs[{{ $pair->id }}][simultaneous_price_hour]" class="nova-input" placeholder="Синхрон" value="{{ optional($latestPrice)->simultaneous_price_hour }}">
                            <input type="number" step="0.01" name="existing_pairs[{{ $pair->id }}][notarial_fee]" class="nova-input" placeholder="Нотариус" value="{{ optional($latestPrice)->notarial_fee }}">
                            <input type="number" step="0.01" name="existing_pairs[{{ $pair->id }}][editing_price_1800]" class="nova-input" placeholder="Редактура" value="{{ optional($latestPrice)->editing_price_1800 }}">
                        </div>
                    </div>
                @empty
                    <div style="font-size: 14px; color: #64748b; margin-bottom: 15px;">У переводчика пока нет языковых пар. Добавьте их ниже.</div>
                @endforelse

                <div style="font-weight: 600; margin: 25px 0 10px 0; font-size: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">Добавить новые языковые пары</div>
                <div id="language-pairs-container"></div>
                <button type="button" onclick="addLanguagePair()" class="nova-input" style="background: #f1f5f9; border: none; cursor: pointer; padding: 8px 16px; margin-top: 5px;">+ Добавить пару</button>
            </div>
        </div>

        <button type="submit" class="nova-input" style="background: #3b82f6; color: white; width: 100%; padding: 15px; border: none; cursor: pointer; border-radius: 4px; font-size: 15px;">Сохранить все изменения</button>
    </form>
</div>

<script>
let pairIndex = 0;

function switchTab(tabName) {
    document.getElementById('tabMain').style.display = tabName === 'main' ? 'block' : 'none';
    document.getElementById('tabPrices').style.display = tabName === 'prices' ? 'block' : 'none';
    
    document.getElementById('btnTabMain').style.background = tabName === 'main' ? '#3b82f6' : '#e2e8f0';
    document.getElementById('btnTabMain').style.color = tabName === 'main' ? '#ffffff' : '#0f172a';
    
    document.getElementById('btnTabPrices').style.background = tabName === 'prices' ? '#3b82f6' : '#e2e8f0';
    document.getElementById('btnTabPrices').style.color = tabName === 'prices' ? '#ffffff' : '#0f172a';
}

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

function addLanguagePair() {
    const container = document.getElementById('language-pairs-container');
    const html = `
    <div style="border: 1px solid #cbd5e1; padding: 15px; margin-bottom: 15px; border-radius: 6px; background: #fff;">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
            <select name="pairs[${pairIndex}][source]" class="nova-input" required style="flex: 1; min-width: 140px;">
                <option value="">Исходный язык</option>
                @foreach($languages as $l)<option value="{{ $l->id }}">{{ $l->title }}</option>@endforeach
            </select>
            <select name="pairs[${pairIndex}][target]" class="nova-input" required style="flex: 1; min-width: 140px;">
                <option value="">Целевой язык</option>
                @foreach($languages as $l)<option value="{{ $l->id }}">{{ $l->title }}</option>@endforeach
            </select>
            <select name="pairs[${pairIndex}][currency]" class="nova-input" style="width: 140px;" required>
                @foreach($currencies as $c)<option value="{{ $c->code }}">{{ $c->code }}</option>@endforeach
            </select>
            <input type="date" name="pairs[${pairIndex}][effective_from]" class="nova-input" value="{{ date('Y-m-d') }}" style="width: 140px;" required>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
            <input type="number" step="0.01" name="pairs[${pairIndex}][written_price_1800]" class="nova-input" placeholder="Письм. 1800">
            <input type="number" step="0.01" name="pairs[${pairIndex}][consecutive_price_hour]" class="nova-input" placeholder="Устный час">
            <input type="number" step="0.01" name="pairs[${pairIndex}][simultaneous_price_hour]" class="nova-input" placeholder="Синхрон">
            <input type="number" step="0.01" name="pairs[${pairIndex}][notarial_fee]" class="nova-input" placeholder="Нотариус">
            <input type="number" step="0.01" name="pairs[${pairIndex}][editing_price_1800]" class="nova-input" placeholder="Редактура">
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    pairIndex++;
}

document.addEventListener("DOMContentLoaded", function() {
    toggleRegions();
});
</script>
@endsection