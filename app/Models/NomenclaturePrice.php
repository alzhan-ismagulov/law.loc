<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NomenclaturePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomenclature_id',
        'purchase_price',
        'selling_price',
        'effective_date',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }
}