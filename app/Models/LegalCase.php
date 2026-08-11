<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    use HasFactory;

    protected $table = 'legal_cases';

    protected $fillable = [
        'base_number',
        'court_number',
        'created_case_date',
        'client_appeal_date',
        'tenant_id',
        'client_id',
        'region_id',
        'service_type_id',
        'proceeding_type_id',
        'instance_id',
        'stage_id',
        'label',
        'fabula',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array', // Автоматически конвертирует JSON из базы в массив PHP и обратно
        'created_case_date' => 'date',
        'client_appeal_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function proceedingType()
    {
        return $this->belongsTo(ProceedingType::class);
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}