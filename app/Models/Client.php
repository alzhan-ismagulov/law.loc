<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clients';

    protected $fillable = [
        'type',
        'name',
        'bin_iin',
        'country',
        'region_id',
        'city',
        'address',
        'contact_person',
        'position',
        'phone',
        'email',
        'password',
        'source',
        'status',
        'discount_percent',
        'bank_name',
        'iban',
        'internal_notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}