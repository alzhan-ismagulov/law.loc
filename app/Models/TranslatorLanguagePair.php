<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslatorLanguagePair extends Model
{
    protected $fillable = [
        'translator_id',
        'source_language_id',
        'target_language_id',
    ];

    public function translator(): BelongsTo
    {
        return $this->belongsTo(Translator::class);
    }

    public function sourceLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'source_language_id');
    }

    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TranslatorPriceHistory::class, 'language_pair_id');
    }

    public function getActivePriceAttribute()
    {
        return $this->prices()->latest('effective_from')->first();
    }
}