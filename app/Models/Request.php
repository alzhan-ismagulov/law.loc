<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'tenant_id',
        'legal_case_id',
        'employee_id',
        'recipient',
        'outgoing_number',
        'outgoing_date',
        'deadline_date',
        'status',
        'description',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'outgoing_date' => 'date',
        'deadline_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}