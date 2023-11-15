<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the inspectingInstitution that owns the InspectionReport
     */
    public function inspectingInstitution(): BelongsTo
    {
        return $this->belongsTo(InspectingInstitution::class, 'inspector_id');
    }

    /**
     * Get the orderItem that owns the InspectionRequest
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
