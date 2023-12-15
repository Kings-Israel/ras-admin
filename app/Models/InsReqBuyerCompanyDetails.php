<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsReqBuyerCompanyDetails extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buyer_company_details';

    protected $casts = [
        'sources_of_income' => 'array',
        'sources_of_wealth' => 'array',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the income tax PIN File
     *
     * @param  string  $value
     * @return string
     */
    public function getIncomeTaxDocumentAttribute($value)
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
