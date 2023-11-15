<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the invoice id
     *
     * @param  string  $value
     * @return string
     */
    public function getInvoiceIdAttribute($value)
    {
        return Str::upper(explode('-', $value)[0]);
    }

    /**
     * Get the user that owns the Invoice
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the orders for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the financingRequest associated with the Invoice
     */
    public function financingRequest(): HasOne
    {
        return $this->hasOne(FinancingRequest::class);
    }

    public function calculateTotalAmount(): int
    {
        $total_amount = 0;

        foreach ($this->orders as $order) {
            foreach($order->orderItems as $order_item) {
                $quantity = explode(' ', $order_item->quantity)[0];
                $total_amount += $order_item->amount * $quantity;
            }
        }

        return $total_amount;
    }

    /**
     * Get the orderFinancing associated with the Invoice
     */
    public function orderFinancing(): HasOne
    {
        return $this->hasOne(OrderFinancing::class);
    }
}
