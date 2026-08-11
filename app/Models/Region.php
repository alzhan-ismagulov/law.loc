<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}
