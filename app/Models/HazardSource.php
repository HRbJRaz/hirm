<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardSource extends Model
{
    protected $fillable = ['name','is_active','sort_order'];
}
