<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoligraphyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomenclature_id',
        'quantity',
        'total_price',
        'material_cost',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }
}