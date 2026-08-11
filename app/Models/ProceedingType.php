<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProceedingType extends Model 
{
    protected $fillable = ['name'];
    
    public function cases() { return $this->hasMany(LegalCase::class); }
}