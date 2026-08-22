<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TranslationOrderFile extends Model
{
    protected $fillable = [
        'translation_order_id',
        'original_file_path',
        'translated_file_path',
        'original_chars_count',
        'translated_chars_count',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TranslationOrder::class, 'translation_order_id');
    }
}