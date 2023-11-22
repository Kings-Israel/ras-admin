<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StorageRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_on' => 'datetime',
        'accepted_on' => 'datetime',
        'received_on' => 'datetime',
        'collected_on' => 'datetime',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the customer that owns the StorageRequest
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the warehouse that owns the StorageRequest
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
