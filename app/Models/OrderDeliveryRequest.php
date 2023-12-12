<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDeliveryRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that owns the OrderDeliveryRequest
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the logisticsCompany that owns the OrderDeliveryRequest
     */
    public function logisticsCompany(): BelongsTo
    {
        return $this->belongsTo(logisticsCompany::class);
    }

    /**
     * Get the orderItem that owns the OrderDeliveryRequest
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function hasCostDescriptionFile(): bool
    {
        if ($this->cost_description_file) {
            return true;
        }

        return false;
    }
}
