<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslatorPriceHistory extends Model
{
    protected $table = 'translator_price_history';

    protected $fillable = [
        'language_pair_id',
        'currency',
        'written_price_1800',
        'consecutive_price_hour',
        'simultaneous_price_hour',
        'notarial_fee',
        'editing_price_1800',
        'effective_from',
    ];

    public function languagePair(): BelongsTo
    {
        return $this->belongsTo(TranslatorLanguagePair::class, 'language_pair_id');
    }

    protected $casts = [
        'effective_from' => 'date',
    ];
}