<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model 
{
    protected $fillable = ['name'];
    
    public function cases() { return $this->hasMany(LegalCase::class); }
}