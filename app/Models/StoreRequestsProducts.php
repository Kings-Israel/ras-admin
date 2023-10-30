<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreRequestsProducts extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='storage_requests_products';


    public function storeRequest()
    {
        return $this->belongsTo(StoreRequest::class, 'request_id');
    }
    public function products():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function packaging(): BelongsTo
    {
        return $this->belongsTo(Packaging::class, 'packaging_id');
    }
}
