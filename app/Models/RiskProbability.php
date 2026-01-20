<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiskProbability extends Model
{
    use HasUuids;
    protected $fillable = [
        'value',
        'name',
        'is_active',
        'sort_order'
        ];
}
