<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the cost description file
     *
     * @param  string  $value
     * @return string
     */
    public function getCostDescriptionFileAttribute($value)
    {
        return config('app.url').'/storage/requests/'.$value;
    }


    public function hasCostDescriptionFile(): bool
    {
        if ($this->cost_description_file && $this->cost_description_file != config('app.url').'/storage/requests/') {
            return true;
        }

        return false;
    }

    /**
     * Get the orderItem that owns the OrderRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function requesteable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the insuranceRequestBuyerDetails for the OrderRequest
     */
    public function insuranceRequestBuyerDetails(): HasOne
    {
        return $this->hasOne(InsReqBuyerDetails::class);
    }

    /**
     * Get all of the insuranceRequestBuyerCompanyDetails for the OrderRequest
     */
    public function insuranceRequestBuyerCompanyDetails(): HasOne
    {
        return $this->hasOne(InsReqBuyerCompanyDetails::class);
    }

    /**
     * Get all of the insuranceRequestBuyerInuranceLossHistories for the OrderRequest
     */
    public function insuranceRequestBuyerInuranceLossHistories(): HasMany
    {
        return $this->hasMany(InsReqBuyerInsuranceLossHistory::class);
    }

    /**
     * Get all of the insuranceRequestProposalDetails for the OrderRequest
     */
    public function insuranceRequestProposalDetails(): hasOne
    {
        return $this->hasOne(InsReqBuyerProposalDetails::class);
    }

    /**
     * Get all of the insuranceRequestProposalVehicleDetails for the OrderRequest
     */
    public function insuranceRequestProposalVehicleDetails(): HasMany
    {
        return $this->hasMany(InsReqBuyerProposalVehicleDetails::class);
    }

    /**
     * Get all of the businessSubsidiaries for the OrderRequest
     */
    public function businessSubsidiaries(): HasMany
    {
        return $this->hasMany(InsReqBusinessSubsidiary::class);
    }

    /**
     * Get the businessInformation associated with the OrderRequest
     */
    public function businessInformation(): HasOne
    {
        return $this->hasOne(InsReqBusinessInformation::class);
    }

    /**
     * Get the businessSalesInformation associated with the OrderRequest
     */
    public function businessSalesInformation(): HasMany
    {
        return $this->hasMany(InsReqBusinessSalesInformation::class);
    }

    /**
     * Get all of the businessSales for the OrderRequest
     */
    public function businessSales(): HasOne
    {
        return $this->hasOne(InsReqBusinessSales::class);
    }

    /**
     * Get all of the businessSalesBadDebts for the OrderRequest
     */
    public function businessSalesBadDebts(): HasMany
    {
        return $this->hasMany(InsReqBusinessSalesBadDebts::class);
    }

    /**
     * Get all of the businessSalesLargeBadDebts for the OrderRequest
     */
    public function businessSalesLargeBadDebts(): HasMany
    {
        return $this->hasMany(InsReqBusinessSalesLargeBadDebts::class);
    }

    /**
     * Get the businessSecurity associated with the OrderRequest
     */
    public function businessSecurity(): HasOne
    {
        return $this->hasOne(InsReqBusinessSecurity::class);
    }

    /**
     * Get the businessCreditManagement associated with the OrderRequest
     */
    public function businessCreditManagement(): HasOne
    {
        return $this->hasOne(InsReqBusinessCreditManagement::class);
    }

    /**
     * Get all of the businessCreditLimits for the OrderRequest
     */
    public function businessCreditLimits(): HasMany
    {
        return $this->hasMany(InsReqBusinessCreditLimit::class);
    }

    /**
     * Get the importInstruction associated with the OrderRequest
     */
    public function importInstruction(): HasOne
    {
        return $this->hasOne(ImportClearingForwardingInstruction::class);
    }

    /**
     * Get the exportInstruction associated with the OrderRequest
     */
    public function exportInstruction(): HasOne
    {
        return $this->hasOne(ExportClearingForwardingInstruction::class);
    }
}
