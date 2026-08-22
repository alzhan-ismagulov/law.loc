<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Translator extends Authenticatable
{
    protected $fillable = [
        'name',
        'country',
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
        'password',
        'status',
        'internal_notes',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'messengers' => 'array',
    ];

    public function languagePairs(): HasMany
    {
        return $this->hasMany(TranslatorLanguagePair::class);
    }

    public function rates()
    {
        return $this->hasMany(TranslatorNomenclatureRate::class);
    }
}