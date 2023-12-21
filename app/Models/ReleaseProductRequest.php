<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReleaseProductRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the orderItem that owns the ReleaseProductRequest
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the warehouse that owns the ReleaseProductRequest
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function resolveBadgeStatus(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-info';
                break;
            case 'complete':
                return 'badge-success';
                break;
            case 'rejected':
                return 'badge-danger';
                break;
            default:
                return 'badge-info';
                break;
        }
    }
}
