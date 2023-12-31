<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Get the order that owns the OrderItem
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the OrderItem
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the inspectionReport associated with the OrderItem
     */
    public function inspectionReport(): HasOne
    {
        return $this->hasOne(InspectionReport::class);
    }

    /**
     * Get the insuranceReport associated with the OrderItem
     */
    public function insuranceReport(): HasOne
    {
        return $this->hasOne(InsuranceReport::class);
    }

    /**
     * Get all of the orderRequests for the OrderItem
     */
    public function orderRequests(): HasMany
    {
        return $this->hasMany(OrderRequest::class);
    }

    /**
     * Get the productReleaseRequest associated with the OrderItem
     */
    public function productReleaseRequest(): HasOne
    {
        return $this->hasOne(ReleaseProductRequest::class);
    }
}
