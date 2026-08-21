<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NomenclatureBom extends Model
{
    use HasFactory;

    protected $table = 'nomenclature_boms';

    protected $fillable = [
        'parent_item_id',
        'material_item_id',
        'quantity',
    ];

    public function parentItem(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class, 'parent_item_id');
    }

    public function materialItem(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class, 'material_item_id');
    }
}