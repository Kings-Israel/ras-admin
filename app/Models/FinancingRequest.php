<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FinancingRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the invoice that owns the FinancingRequest
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the financingInstitution that owns the FinancingRequest
     */
    public function financingInstitution(): BelongsTo
    {
        return $this->belongsTo(FinancingInstitution::class);
    }

    /**
     * Get the anchorHistory associated with the FinancingRequest
     */
    public function anchorHistory(): HasOne
    {
        return $this->hasOne(FinancingRequestAnchorHistory::class);
    }

    /**
     * Get all of the bankDebts for the FinancingRequest
     */
    public function bankDebts(): HasMany
    {
        return $this->hasMany(FinancingRequestBankDebt::class);
    }

    /**
     * Get all of the operatingDebts for the FinancingRequest
     */
    public function operatingDebts(): HasMany
    {
        return $this->hasMany(FinancingRequestOperatingDebt::class);
    }

    /**
     * Get all of the bankers for the FinancingRequest
     */
    public function bankers(): HasMany
    {
        return $this->hasMany(FinancingRequestBanker::class);
    }

    /**
     * Get the capitalStructure associated with the FinancingRequest
     */
    public function capitalStructure(): HasOne
    {
        return $this->hasOne(FinancingRequestCapitalStructure::class);
    }

    /**
     * Get all of the companyManagers for the FinancingRequest
     */
    public function companyManagers(): HasMany
    {
        return $this->hasMany(FinancingRequestCompanyManagement::class);
    }

    /**
     * Get all of the shareholders for the FinancingRequest
     */
    public function shareholders(): HasMany
    {
        return $this->hasMany(FinancingRequestShareholder::class);
    }

    /**
     * Get the company associated with the FinancingRequest
     */
    public function company(): HasOne
    {
        return $this->hasOne(FinancingRequestCompany::class);
    }

    /**
     * Get all of the documents for the FinancingRequest
     */
    public function documents(): HasMany
    {
        return $this->hasMany(FinancingRequestDocument::class);
    }
}
