<?php

namespace App\Models;

use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    protected $fillable = [
        'designator',
        'name',
        'div_id',
        'address',
        'phone',
        'fax',
        'afs',
        'manager_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Unit has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Unit manager (User with UUID)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Optional future relationship
    public function division()
    {
        return $this->belongsTo(Division::class, 'div_id');
    }
}
