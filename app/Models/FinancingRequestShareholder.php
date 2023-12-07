<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancingRequestShareholder extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the financingRequest that owns the FinancingRequestShareholder
     */
    public function financingRequest(): BelongsTo
    {
        return $this->belongsTo(FinancingRequest::class);
    }
}
