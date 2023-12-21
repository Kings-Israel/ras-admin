<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wing extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function locations()
    {
        return $this->hasMany(WingLocation::class);
    }

}
