<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'title',
        'slug',
    ];

    public $timestamps = false; // Отключаем автоматическое заполнение created_at и updated_at
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}