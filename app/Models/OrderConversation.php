<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderConversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'conversation_id'];

    /**
     * Get the order that owns the OrderConversation
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
