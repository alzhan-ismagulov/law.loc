<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'legal_case_id',
        'creator_id',
        'executor_id',
        'title',
        'description',
        'due_date',
        'status',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'due_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'creator_id');
    }

    public function executor()
    {
        return $this->belongsTo(Employee::class, 'executor_id');
    }
}