<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRequest extends Model
{
    use HasFactory;
    protected $table='store_requests';
    protected $guarded=[''];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'customer_id');
    }
}
