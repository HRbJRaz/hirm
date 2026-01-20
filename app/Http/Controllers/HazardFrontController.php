<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Hazard;
use App\Models\HazardScope;
use App\Models\HazardSource;
use App\Models\RiskSeverity;
use Illuminate\Http\Request;
use App\Models\RiskProbability;

class HazardFrontController extends Controller
{
    public function create()
    {
        return view('hazards.create', [
            'units' => Unit::orderBy('name')->get(),
            'sources' => HazardSource::where('is_active', true)->orderBy('sort_order')->get(),
            'scopes' => HazardScope::where('is_active', true)->orderBy('sort_order')->get(),
            'probability' => RiskProbability::where('is_active', true)->orderBy('sort_order')->get(),
            'severity' => RiskSeverity::where('is_active', true)->orderBy('sort_order')->get(),
            'firs' => ['KL FIR', 'KK FIR'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date_registered' => ['required', 'date'],
            'unit_id' => ['required', 'exists:units,id'],
            'fir' => ['required', 'in:KL FIR,KK FIR'],
            'source_id' => ['required', 'exists:hazard_sources,id'],
            'scope_id' => ['required', 'exists:hazard_scopes,id'],
            'generic_hazard' => ['required', 'string'],
            'specific_hazard' => ['required', 'string'],
            'occurrence_date' => ['nullable', 'date'],
            'description' => ['required', 'string'],
            'consequence' => ['required', 'string'],
            'initial_risk_rating_id' => ['required', 'exists:risk_ratings,id'],
        ]);

        // hazard_ref generation should be in the model booted() or service
        Hazard::create($data);

        return redirect()->route('dashboard')->with('status', 'Hazard submitted successfully.');
    }
}