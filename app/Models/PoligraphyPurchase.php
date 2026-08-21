<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoligraphyPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomenclature_id',
        'quantity',
        'purchase_price',
        'total_amount',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }
}