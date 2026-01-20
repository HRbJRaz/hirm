<?php

namespace App\Models;

use App\Models\SrmRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HazardAction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'hazard_id',
        'is_corrective_action',
        'is_mitigation_action',
        'sra_sr_ref',
        'sra_sr_file_path',
        'priority',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'is_corrective_action' => 'boolean',
        'is_mitigation_action' => 'boolean',
        'due_date' => 'date',
    ];

    public function hazard()
    {
        return $this->belongsTo(Hazard::class);
    }

    public function srmRecord()
    {
        return $this->hasOne(SrmRecord::class);
    }
}