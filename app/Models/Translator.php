<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Translator extends Model
{
    protected $fillable = [
        'name',
        'photo_path',
        'region_id',
        'city',
        'address',
        'diploma_path',
        'card_number',
        'card_type',
        'bank_name',
        'iban',
        'phone',
        'messengers',
        'email',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'messengers' => 'array',
    ];

    public function languagePairs(): HasMany
    {
        return $this->hasMany(TranslatorLanguagePair::class);
    }
}