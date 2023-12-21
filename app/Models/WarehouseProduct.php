<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WarehouseProduct extends Model
{
    use HasFactory;
    protected $guarded=[''];
    protected $table='warehouse_products';

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function winglocation()
    {
        return $this->belongsTo(WingLocation::class, 'wing_locations_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
