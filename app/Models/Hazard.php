<?php

namespace App\Models;

use App\Models\RiskRating;
use App\Models\HazardScope;
use App\Models\HazardAction;
use App\Models\HazardSource;
use App\Models\RiskSeverity;
use App\Models\RiskProbability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hazard extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'hazard_ref',
        'date_registered',
        'unit_id',
        'fir',
        'source',
        'scope',
        'generic_hazard',
        'specific_hazard',
        'occurrence_date',
        'description',
        'consequence',
        'initial_severity_id',
        'initial_probability_id',
    ];

    protected $casts = [
        'date_registered' => 'date',
        'occurrence_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($hazard) {
            if (! $hazard->hazard_ref) {
                $year = now()->year;
                $count = self::whereYear('created_at', $year)->count() + 1;

                $hazard->hazard_ref = sprintf(
                    'HZ-%s-%s-%04d',
                    $hazard->unit?->designator ?? 'GEN',
                    $year,
                    $count
                );
            }
        });

        static::saving(function (Hazard $hazard) {

            // Only calculate when both are present
            if ($hazard->initial_probability_id && $hazard->initial_severity_id) {
                $prob = RiskProbability::find($hazard->initial_probability_id);
                $sev  = RiskSeverity::find($hazard->initial_severity_id);

                if ($prob && $sev) {
                    // e.g. 4B
                    $hazard->initial_risk_index = $prob->value . $sev->code;

                    // Simple default tolerability rule (you can replace later with your matrix)
                    // Typical: high probability + high severity => Intolerable
                    $hazard->initial_tolerability = self::defaultTolerability($prob->value, $sev->code);
                }
            }
        });
    }

    private static function defaultTolerability(int $probValue, string $sevCode): string
    {
        // Basic starter bands (adjust later)
        // Treat A/B with high prob as intolerable
        if (in_array($sevCode, ['A', 'B'], true) && $probValue >= 3) return 'Intolerable';
        if (in_array($sevCode, ['A', 'B'], true) && $probValue == 2) return 'Tolerable';
        if ($sevCode === 'C' && $probValue >= 4) return 'Intolerable';
        if ($sevCode === 'C' && $probValue >= 2) return 'Tolerable';
        if (in_array($sevCode, ['D', 'E'], true) && $probValue >= 4) return 'Tolerable';

        return 'Acceptable';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function hazardsource() 
    { 
        return $this->belongsTo(HazardSource::class, 'source_id'); 
    }
    public function hazardscope() 
    { 
        return $this->belongsTo(HazardScope::class, 'scope_id'); 
    }
    public function initialSeverity()
    {
        return $this->belongsTo(RiskSeverity::class, 'initial_severity_id');
    }

    public function initialProbability()
    {
        return $this->belongsTo(RiskProbability::class, 'initial_probability_id');
    }

    public function actions()
    {
        return $this->hasMany(HazardAction::class);
    }
}
