<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TranslationOrder;
use App\Models\TranslationOrderFile;
use App\Models\Client;
use App\Models\Translator;
use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TranslationOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = TranslationOrder::with(['client', 'translator', 'nomenclature.parent', 'files'])
            ->where('user_id', auth()->id());

        // Фильтрация по датам
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();
        $totalSum = $orders->sum('client_price');

        return view('admin.translations.index', compact('orders', 'totalSum'));
    }

    public function create()
    {
        $clients = Client::all();
        $translators = Translator::all();
        
        $nomenclatureServices = Nomenclature::with('currentPrice')
            ->where('type', 'item')
            ->whereHas('parent', function ($query) {
                $query->where('name', 'Переводческие услуги');
            })
            ->get();

        return view('admin.translations.create', compact('clients', 'translators', 'nomenclatureServices'));
    }

    // Вспомогательный метод для точного подсчета знаков конкретного файла
    private function extractFileChars($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $charsCount = 0;

        if ($extension === 'txt' || $extension === 'csv') {
            $charsCount = mb_strlen(file_get_contents($file->getRealPath()));
        } elseif ($extension === 'docx') {
            $zip = new \ZipArchive();
            if ($zip->open($file->getRealPath()) === TRUE) {
                $xml = $zip->getFromName('word/document.xml');
                $zip->close();
                if ($xml) {
                    $dom = new \DOMDocument();
                    @$dom->loadXML($xml);
                    $charsCount = mb_strlen(strip_tags($dom->saveXML()));
                }
            }
        }
        return $charsCount;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'translator_id' => 'nullable|exists:translators,id',
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'service_type' => 'required|string',
            'order_date' => 'required|date',
            'client_price' => 'required|numeric|min:0',
            'translator_price' => 'nullable|numeric|min:0',
            'chars_count' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'files.*' => 'nullable|file|max:10240',
        ]);

        $order = TranslationOrder::create([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'translator_id' => $validated['translator_id'] ?? null,
            'nomenclature_id' => $validated['nomenclature_id'],
            'service_type' => $validated['service_type'],
            'order_date' => $validated['order_date'],
            'status' => 'new',
            'client_price' => $validated['client_price'],
            'translator_price' => $validated['translator_price'] ?? 0,
            'is_client_paid' => false,
            'is_translator_paid' => false,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Сохранение файлов с исходным именем
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('translation_originals', time() . '_' . $originalName, 'public');
                $fileChars = $this->extractFileChars($file);

                TranslationOrderFile::create([
                    'translation_order_id' => $order->id,
                    'original_file_path' => $path,
                    'original_chars_count' => $fileChars,
                ]);
            }
        }

        return redirect()->route('admin.translations.index')
            ->with('success', 'Заказ на перевод успешно создан.');
    }

    public function edit($id)
    {
        $order = TranslationOrder::with('files')->where('user_id', auth()->id())->findOrFail($id);
        $clients = Client::all();
        $translators = Translator::all();
        
        $nomenclatureServices = Nomenclature::with('currentPrice')
            ->where('type', 'item')
            ->whereHas('parent', function ($query) {
                $query->where('name', 'Переводческие услуги');
            })
            ->get();

        return view('admin.translations.edit', compact('order', 'clients', 'translators', 'nomenclatureServices'));
    }

    public function update(Request $request, $id)
    {
        $order = TranslationOrder::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'translator_id' => 'nullable|exists:translators,id',
            'nomenclature_id' => 'required|exists:nomenclatures,id',
            'service_type' => 'required|string',
            'order_date' => 'required|date',
            'client_price' => 'required|numeric|min:0',
            'translator_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'files.*' => 'nullable|file|max:10240',
        ]);

        $order->update([
            'client_id' => $validated['client_id'],
            'translator_id' => $validated['translator_id'] ?? null,
            'nomenclature_id' => $validated['nomenclature_id'],
            'service_type' => $validated['service_type'],
            'order_date' => $validated['order_date'],
            'client_price' => $validated['client_price'],
            'translator_price' => $validated['translator_price'] ?? $order->translator_price,
            'notes' => $validated['notes'] ?? $order->notes,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('translation_originals', time() . '_' . $originalName, 'public');
                $fileChars = $this->extractFileChars($file);

                TranslationOrderFile::create([
                    'translation_order_id' => $order->id,
                    'original_file_path' => $path,
                    'original_chars_count' => $fileChars,
                ]);
            }
        }

        return redirect()->route('admin.translations.index')
            ->with('success', 'Заказ на перевод успешно обновлен.');
    }

    public function show($id)
    {
        $order = TranslationOrder::with(['client', 'translator', 'nomenclature', 'files'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('admin.translations.show', compact('order'));
    }

    public function uploadTranslation(Request $request, $fileId)
    {
        $request->validate([
            'translated_file' => 'required|file|max:10240',
        ]);

        $orderFile = TranslationOrderFile::with('order.translator.languagePairs.prices')->findOrFail($fileId);

        if ($orderFile->order->user_id !== auth()->id()) {
            abort(403);
        }

        $file = $request->file('translated_file');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('translation_results', time() . '_' . $originalName, 'public');
        
        $charsCount = $this->extractFileChars($file);

        $orderFile->update([
            'translated_file_path' => $path,
            'translated_chars_count' => $charsCount,
        ]);

        $order = $orderFile->order;

        if ($order->service_type === 'written' || $order->service_type === 'editing') {
            $totalTranslatedChars = $order->files()->sum('translated_chars_count');

            if ($totalTranslatedChars > 0) {
                $translator = $order->translator;
                $translatorRate = 0;

                if ($translator) {
                    $pair = $translator->languagePairs()->first();
                    $latestPrice = $pair?->prices()->orderByDesc('effective_from')->first();
                    $translatorRate = $latestPrice?->written_price_1800 ?? 0;
                }

                if ($translatorRate <= 0 && $order->translator_price > 0) {
                    $translatorRate = $order->translator_price; 
                }

                $clientRate = $translatorRate > 0 ? $translatorRate * 1.5 : 2000; 

                $order->translator_price = round(($totalTranslatedChars / 1800) * $translatorRate, 2);
                $order->client_price = round(($totalTranslatedChars / 1800) * $clientRate, 2);
                $order->save();
            }
        }

        return back()->with('success', 'Файл перевода успешно загружен.');
    }

    public function parseFileChars(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $charsCount = $this->extractFileChars($request->file('file'));

        return response()->json(['chars_count' => $charsCount]);
    }

    public function getTranslatorServices(Request $request)
    {
        try {
            $translatorId = $request->get('translator_id');
            $serviceType = $request->get('service_type', 'written');
            
            $translator = Translator::with(['languagePairs.sourceLanguage', 'languagePairs.targetLanguage', 'languagePairs.prices'])->find($translatorId);

            if (!$translator) {
                return response()->json(['error' => 'Переводчик не найден'], 404);
            }

            $services = [];
            foreach ($translator->languagePairs as $pair) {
                $latestPrice = $pair->prices->sortByDesc('effective_from')->first();
                
                $translatorPrice = 0;
                if ($latestPrice) {
                    if ($serviceType === 'written') {
                        $translatorPrice = $latestPrice->written_price_1800 ?? 0;
                    } elseif ($serviceType === 'oral') {
                        $translatorPrice = $latestPrice->consecutive_price_hour ?? 0;
                    } elseif ($serviceType === 'sync') {
                        $translatorPrice = $latestPrice->simultaneous_price_hour ?? 0;
                    } elseif ($serviceType === 'notary') {
                        $translatorPrice = $latestPrice->notarial_fee ?? 0;
                    } elseif ($serviceType === 'editing') {
                        $translatorPrice = $latestPrice->editing_price_1800 ?? 0;
                    }
                }

                $sourceName = $pair->sourceLanguage?->title ?? '';
                $targetName = $pair->targetLanguage?->title ?? '';

                $nomenclatureItem = Nomenclature::with('currentPrice')
                    ->where('type', 'item')
                    ->where(function($q) use ($sourceName, $targetName) {
                        $q->where('name', 'like', "%с {$sourceName} на {$targetName}%")
                          ->orWhere('name', 'like', "%{$sourceName} → {$targetName}%");
                    })
                    ->first();

                $pairName = $nomenclatureItem ? $nomenclatureItem->name : "Перевод с {$sourceName} на {$targetName} язык";
                $clientPrice = $nomenclatureItem?->currentPrice?->selling_price ?? ($translatorPrice > 0 ? $translatorPrice * 1.5 : 2000);

                $services[] = [
                    'nomenclature_id' => $nomenclatureItem?->id ?? 1,
                    'name' => $pairName,
                    'client_price' => $clientPrice,
                    'translator_price' => $translatorPrice,
                ];
            }

            return response()->json(['services' => $services]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function togglePayment(Request $request, $id)
    {
        $order = TranslationOrder::where('user_id', auth()->id())->findOrFail($id);
        $type = $request->get('type');
        
        if ($type === 'client') {
            $order->is_client_paid = !$order->is_client_paid;
            if ($request->hasFile('payment_receipt')) {
                $file = $request->file('payment_receipt');
                $order->client_receipt_path = $file->storeAs('receipts/clients', time() . '_' . $file->getClientOriginalName(), 'public');
            }
        } elseif ($type === 'translator') {
            $order->is_translator_paid = !$order->is_translator_paid;
            if ($request->hasFile('payment_receipt')) {
                $file = $request->file('payment_receipt');
                $order->translator_receipt_path = $file->storeAs('receipts/translators', time() . '_' . $file->getClientOriginalName(), 'public');
            }
        }
        
        $order->save();

        return back()->with('success', 'Статус оплаты успешно обновлен.');
    }

    public function destroyFile($fileId)
    {
        $file = TranslationOrderFile::with('order')->findOrFail($fileId);
        if ($file->order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($file->original_file_path) {
            Storage::disk('public')->delete($file->original_file_path);
        }
        if ($file->translated_file_path) {
            Storage::disk('public')->delete($file->translated_file_path);
        }

        $file->delete();
        return back()->with('success', 'Файл успешно удален.');
    }

    public function destroy(TranslationOrder $translation)
    {
        foreach ($translation->files as $file) {
            if ($file->original_file_path && Storage::disk('public')->exists($file->original_file_path)) {
                Storage::disk('public')->delete($file->original_file_path);
            }
            if ($file->translated_file_path && Storage::disk('public')->exists($file->translated_file_path)) {
                Storage::disk('public')->delete($file->translated_file_path);
            }
            $file->delete();
        }

        $translation->delete();

        return redirect()->route('admin.translations.index')->with('success', 'Заказ успешно удален.');
    }
}