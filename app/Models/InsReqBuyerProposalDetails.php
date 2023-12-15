<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsReqBuyerProposalDetails extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buyer_proposal_details';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'transported_products' => 'array',
        'vehicle_features' => 'array',
        'previous_insurance_data' => 'array',
        'previous_insurer' => 'array',
    ];

    /**
     * Get the orderRequest that owns the InsReqBuyerCompanyDetails
     */
    public function orderRequest(): BelongsTo
    {
        return $this->belongsTo(OrderRequest::class);
    }
}
