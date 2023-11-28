<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderRequest extends Model
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
        return config('app.url').'/storage/requests/'.$value;
    }

    /**
     * Get the orderItem that owns the OrderRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function requesteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function hasCostDescriptionFile(): bool
    {
        if ($this->cost_description_file && $this->cost_description_file != config('app.url').'/storage/requests/') {
            return true;
        }

        return false;
    }
}
