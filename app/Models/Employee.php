<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iin',
        'email',
        'phone',
        'password',
        'role_id',
        'region_id',
        'tenant_id',
        'status',
        'salary',
        'hired_at',
        'fired_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}