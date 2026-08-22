<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslatorNomenclatureRate extends Model
{
    protected $fillable = ['translator_id', 'nomenclature_id', 'rate_price'];
}
