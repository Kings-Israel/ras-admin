<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WarehouseProduct extends Model
{
    use HasFactory;
    protected $table='warehouse_products';

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

//    public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
