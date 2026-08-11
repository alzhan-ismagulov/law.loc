<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'iin_bin',
        'phone',
        'email',
        'birth_date',
        'address',
        'id_card_number',
        'id_card_date',
        'id_card_issuer',
        'tenant_id',
        'region_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function cases()
    {
        return $this->hasMany(LegalCase::class); // Связь с судебными делами клиента
    }
}