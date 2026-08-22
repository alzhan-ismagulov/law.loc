<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nomenclature extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'type',
        'category_type',
        'department_id',
        'base_unit',
        'purchase_unit',
        'conversion_factor',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Nomenclature::class, 'parent_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(NomenclaturePrice::class)->orderBy('effective_date', 'desc');
    }

    // Актуальная цена на текущую дату
    public function currentPrice(): HasOne
    {
        return $this->hasOne(NomenclaturePrice::class)
            ->where('effective_date', '<=', now())
            ->orderBy('effective_date', 'desc');
    }

    // Спецификация (если это услуга, из каких материалов состоит)
    public function bomItems(): HasMany
    {
        return $this->hasMany(NomenclatureBom::class, 'parent_item_id');
    }

    // Себестоимость единицы (если закупается пачками, пересчитываем на базовую единицу)
    public function getBasePurchasePriceAttribute()
    {
        $price = $this->currentPrice?->purchase_price ?? 0;
        $factor = $this->conversion_factor > 0 ? $this->conversion_factor : 1;
        return $price / $factor;
    }
}