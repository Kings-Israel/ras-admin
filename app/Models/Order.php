<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the order id
     *
     * @param  string  $value
     * @return string
     */
    public function getOrderIdAttribute($value)
    {
        return Str::upper(explode('-', $value)[0]);
    }

    /**
     * Get the user that owns the Order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the orderItems for the Order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the invoice that owns the Order
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the business that owns the Order
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the warehouse that owns the Order
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(WarehouseOrder::class, 'id', 'order_id');
    }

    /**
     * Get the driver associated with the Order
     */
    public function driver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'driver_id');
    }

    public function resolveOrderBadgeStatus(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-info';
                break;
            case 'accepted':
                return 'badge-success';
                break;
            case 'rejected':
                return 'badge-danger';
                break;
            case 'in progress':
                return 'badge-warning';
                break;
            case 'delivered':
                return 'badge-success';
                break;
            case 'cancelled':
                return 'badge-danger';
                break;
            default:
                return 'badge-info';
                break;
        }
    }

    public function resolveOrderBadgePaymentStatus(): string
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-info';
                break;
            case 'paid':
                return 'badge-success';
                break;
            default:
                return 'badge-info';
                break;
        }
    }

    public function checkInspectionIsComplete(): DateTime|bool
    {
        $last_inspection_report_date = $this->updated_at;
        foreach ($this->orderItems as $item) {
            if (!$item->inspectionReport()->exists()) {
                return false;
            }

            if (Carbon::parse($item->inspectionReport->created_at)->greaterThan(Carbon::parse($last_inspection_report_date))) {
                $last_inspection_report_date = $item->inspectionReport->created_at;
            }
        }

        return $last_inspection_report_date;
    }
}
