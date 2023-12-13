<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStorageRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the cost description file
     *
     * @param  string  $value
     * @return string
     */
    public function getCostDescriptionFileAttribute($value)
    {
        return config('app.url').'/storage/requests/warehousing/'.$value;
    }

    /**
     * Get the orderItem that owns the OrderStorageRequest
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the warehouse that owns the OrderStorageRequest
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function hasCostDescriptionFile(): bool
    {
        if ($this->cost_description_file && $this->cost_description_file != config('app.url').'/storage/requests/warehousing/') {
            return true;
        }

        return false;
    }
}
