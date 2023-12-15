<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsReqBuyerDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'income_sources' => 'array',
        'wealth_sources' => 'array',
    ];

    /**
     * Get the income tax file
     *
     * @param  string  $value
     * @return string
     */
    public function getIncomeTaxPinFileAttribute($value)
    {
        return config('app.frontend_url').'/storage/insurance/doc/'.$value;
    }

    /**
     * Get the orderRequest that owns the InsReqBuyerCompanyDetails
     */
    public function orderRequest(): BelongsTo
    {
        return $this->belongsTo(OrderRequest::class);
    }
}
