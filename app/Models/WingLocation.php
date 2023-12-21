<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WingLocation extends Model
{
    use HasFactory;
    protected $guarded=[''];
    public function wing()
    {
        return $this->belongsTo(Wing::class);
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
