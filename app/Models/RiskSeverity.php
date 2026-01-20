<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiskSeverity extends Model
{
    use HasUuids;
    protected $fillable = [
        'code',
        'name',
        'is_active',
        'sort_order'
        ];
}
