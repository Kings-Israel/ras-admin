<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $guarded=[''];
    public function location()
    {
        return $this->belongsTo(WingLocation::class);
    }
}
