@extends('layouts.app')

@section('content')
<div class="nova-card-table" style="margin: 0 auto; padding: 30px; max-width: 700px;">
    
    <div style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">
        Редактирование заказа на перевод №{{ $order->id }}
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

    <form action="{{ route('admin.translations.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Дата заказа</label>
            <input type="date" name="order_date" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ $order->order_date }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Клиент</label>
            <select name="client_id" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                <option value="">-- Выберите клиента --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $order->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Тип перевода</label>
            <select name="service_type" id="service_type_select" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                <option value="written" {{ $order->service_type == 'written' ? 'selected' : '' }}>Письменный (за 1800 знаков)</option>
                <option value="oral" {{ $order->service_type == 'oral' ? 'selected' : '' }}>Устный (за час)</option>
                <option value="sync" {{ $order->service_type == 'sync' ? 'selected' : '' }}>Синхронный (за час)</option>
                <option value="notary" {{ $order->service_type == 'notary' ? 'selected' : '' }}>Нотариальное заверение</option>
                <option value="editing" {{ $order->service_type == 'editing' ? 'selected' : '' }}>Редактура</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Переводчик</label>
            <select name="translator_id" id="translator_select" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                <option value="">-- Выберите переводчика --</option>
                @foreach($translators as $translator)
                    <option value="{{ $translator->id }}" {{ $order->translator_id == $translator->id ? 'selected' : '' }}>{{ $translator->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Языковая пара переводчика</label>
            <select id="translator_pair_select" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                <option value="">-- Выберите языковую пару --</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Услуга из справочника Номенклатура</label>
            <select name="nomenclature_id" id="nomenclature_select" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" required>
                <option value="">-- Выберите позицию из номенклатуры --</option>
                @foreach($nomenclatureServices ?? [] as $service)
                    <option value="{{ $service->id }}" {{ $order->nomenclature_id == $service->id ? 'selected' : '' }} data-selling-price="{{ $service->currentPrice?->selling_price ?? 0 }}">
                        {{ $service->name }} (Цена: {{ $service->currentPrice?->selling_price ?? 0 }} тг.)
                    </option>
                @endforeach
            </select>
        </div>

        <div id="file_upload_block" style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Добавить новые файлы оригинала</label>
            <input type="file" name="files[]" multiple class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc;">
        </div>

        @php
            $totalOriginalChars = $order->files->sum('original_chars_count');
        @endphp

        <div id="chars_block" style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Количество знаков с пробелами</label>
            <input type="number" id="chars_count_input" name="chars_count" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ $totalOriginalChars }}" min="0">
        </div>

        <!-- Поле для примечания клиента -->
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Примечание к заказу (пожелания клиента, глоссарий)</label>
            <textarea name="notes" rows="3" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: normal; font-style: normal; text-transform: none;" placeholder="Введите примечание словами...">{{ old('notes', $order->notes) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Стоимость для клиента (тенге)</label>
            <input type="number" step="0.01" id="client_price_input" name="client_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ $order->client_price }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 5px;">Стоимость для переводчика (тенге)</label>
            <input type="number" step="0.01" id="translator_price_input" name="translator_price" class="nova-input" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;" value="{{ $order->translator_price }}" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="nova-input" style="background-color: #3b82f6; color: #ffffff; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; width: auto;">Сохранить изменения</button>
            <a href="{{ route('admin.translations.index') }}" class="nova-input" style="background-color: #e2e8f0; color: #0f172a; text-decoration: none; cursor: pointer; padding: 8px 20px; border: none; border-radius: 4px; display: inline-block; width: auto; text-align: center;">Отмена</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceTypeSelect = document.getElementById('service_type_select');
        const translatorSelect = document.getElementById('translator_select');
        const translatorPairSelect = document.getElementById('translator_pair_select');
        const nomenclatureSelect = document.getElementById('nomenclature_select');
        const charsInput = document.getElementById('chars_count_input');
        const clientPriceInput = document.getElementById('client_price_input');
        const translatorPriceInput = document.getElementById('translator_price_input');
        const fileUploadBlock = document.getElementById('file_upload_block');
        const charsBlock = document.getElementById('chars_block');
        const fileInput = document.querySelector('input[name="files[]"]');

        let currentTranslatorRate = 0;
        let currentClientRate = 0;

        function toggleServiceTypeFields() {
            const type = serviceTypeSelect.value;
            if (type === 'oral' || type === 'sync') {
                fileUploadBlock.style.display = 'none';
                charsBlock.style.display = 'none';
                charsInput.value = 1; 
            } else {
                fileUploadBlock.style.display = 'block';
                charsBlock.style.display = 'block';
            }
            loadTranslatorPairs();
        }

        serviceTypeSelect.addEventListener('change', toggleServiceTypeFields);

        function loadTranslatorPairs() {
            const translatorId = translatorSelect.value;
            const serviceType = serviceTypeSelect.value;

            if (!translatorId) {
                translatorPairSelect.innerHTML = '<option value="">-- Сначала выберите переводчика --</option>';
                return;
            }

            translatorPairSelect.innerHTML = '<option value="">-- Загрузка пар... --</option>';

            fetch(`/admin/translations/get-translator-services?translator_id=${translatorId}&service_type=${serviceType}`)
                .then(response => response.json())
                .then(data => {
                    translatorPairSelect.innerHTML = '<option value="">-- Выберите языковую пару --</option>';
                    if (data.services && data.services.length > 0) {
                        data.services.forEach(service => {
                            let option = document.createElement('option');
                            option.value = service.nomenclature_id;
                            option.setAttribute('data-client-price', service.client_price);
                            option.setAttribute('data-translator-price', service.translator_price);
                            option.textContent = `${service.name} (Ставка переводчика: ${service.translator_price} тг.)`;
                            translatorPairSelect.appendChild(option);
                        });
                    } else {
                        translatorPairSelect.innerHTML = '<option value="">-- У переводчика нет пар для этого типа --</option>';
                    }
                    
                    // Если у номенклатуры уже выбрана цена, подставим её
                    const selectedNomenclature = nomenclatureSelect.options[nomenclatureSelect.selectedIndex];
                    if (selectedNomenclature) {
                        currentClientRate = parseFloat(selectedNomenclature.getAttribute('data-selling-price')) || 0;
                    }
                    calculatePrices();
                })
                .catch(error => {
                    console.error('Ошибка загрузки пар:', error);
                    translatorPairSelect.innerHTML = '<option value="">-- Ошибка загрузки --</option>';
                });
        }

        translatorSelect.addEventListener('change', loadTranslatorPairs);

        translatorPairSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            currentTranslatorRate = parseFloat(selectedOption.getAttribute('data-translator-price')) || 0;
            calculatePrices();
        });

        nomenclatureSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            currentClientRate = parseFloat(selectedOption.getAttribute('data-selling-price')) || 0;
            calculatePrices();
        });

        charsInput.addEventListener('input', calculatePrices);

        function calculatePrices() {
            const type = serviceTypeSelect.value;
            const chars = parseFloat(charsInput.value) || 0;

            if (type === 'oral' || type === 'sync') {
                clientPriceInput.value = currentClientRate.toFixed(2);
                translatorPriceInput.value = currentTranslatorRate.toFixed(2);
            } else {
                clientPriceInput.value = ((chars / 1800) * currentClientRate).toFixed(2);
                translatorPriceInput.value = ((chars / 1800) * currentTranslatorRate).toFixed(2);
            }
        }

        // Автоматический подсчет знаков для новых добавляемых файлов
        if (fileInput) {
            fileInput.addEventListener('change', async function () {
                if (this.files && this.files.length > 0 && serviceTypeSelect.value === 'written') {
                    let additionalChars = 0;

                    for (let i = 0; i < this.files.length; i++) {
                        let formData = new FormData();
                        formData.append('file', this.files[i]);
                        formData.append('_token', '{{ csrf_token() }}');

                        try {
                            let response = await fetch('{{ route("admin.translations.parse-file") }}', {
                                method: 'POST',
                                body: formData
                            });
                            let data = await response.json();
                            if (data.chars_count !== undefined) {
                                additionalChars += parseInt(data.chars_count) || 0;
                            }
                        } catch (e) {
                            console.error('Ошибка при подсчете знаков файла:', e);
                        }
                    }

                    // Прибавляем к существующим знакам в заказе
                    let existingChars = parseInt(charsInput.value) || 0;
                    charsInput.value = existingChars + additionalChars;
                    calculatePrices();
                }
            });
        }

        // Первичная инициализация при загрузке страницы редактирования
        if (translatorSelect.value) {
            loadTranslatorPairs();
        }
        const initialNomenclature = nomenclatureSelect.options[nomenclatureSelect.selectedIndex];
        if (initialNomenclature) {
            currentClientRate = parseFloat(initialNomenclature.getAttribute('data-selling-price')) || 0;
        }
    });
</script>
@endsection