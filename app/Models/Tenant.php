<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'legal_form',
        'bin_iin',
        'specialization',
        'license_number',
        'registration_region',
        'location_region',
        'city',
        'actual_address',
        'director_name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function cases()
    {
        return $this->hasMany(LegalCase::class);
    }
}