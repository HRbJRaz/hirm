<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SrmRecord extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'hazard_action_id',
        'responsible_division_id',
        'responsible_unit_id',
        'estimated_implementation_date',
        'implementation_details',
        'evidence_path',
        'actual_completion_date',
        'severity_id',
        'probability_id',
        'risk_index',
        'status',
        'remarks',
    ];

    protected $casts = [
        'estimated_implementation_date' => 'date',
        'actual_completion_date' => 'date',
    ];

    public function hazardAction()
    {
        return $this->belongsTo(HazardAction::class);
    }

    public function severity()
    {
        return $this->belongsTo(RiskSeverity::class, 'severity_id');
    }

    public function probability()
    {
        return $this->belongsTo(RiskProbability::class, 'probability_id');
    }

    public function responsible()
    {
        return match ($this->responsible_type) {
            'division' => Division::find($this->responsible_id),
            'unit' => Unit::find($this->responsible_id),
            default => null,
        };
    }

    protected static function booted(): void
    {
        static::saving(function (self $record) {
            if ($record->severity_id && $record->probability_id) {
                $sev = RiskSeverity::find($record->severity_id);
                $prob = RiskProbability::find($record->probability_id);

                if ($sev && $prob) {
                    $record->risk_index = $prob->value . $sev->code;
                }
            }

            // Auto-set completion date
            if ($record->status === 'Closed' && ! $record->actual_completion_date) {
                $record->actual_completion_date = now()->toDateString();
            }
        });
    }

    public function getResponsibleNameAttribute(): ?string
    {
        return $this->responsible()?->name;
    }
}
