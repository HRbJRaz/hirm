<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'abbr',
        'director_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Division has many units
    public function units()
    {
        return $this->hasMany(Unit::class, 'div_id');
    }

    // Division director (User with UUID)
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }
}
