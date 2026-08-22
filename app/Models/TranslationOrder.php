<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationOrder extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'translator_id',
        'nomenclature_id',
        'service_type',
        'order_date',
        'status',
        'client_price',
        'translator_price',
        'is_client_paid',
        'is_translator_paid',
        'notes',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function translator(): BelongsTo
    {
        return $this->belongsTo(Translator::class);
    }

    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(TranslationOrderFile::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}