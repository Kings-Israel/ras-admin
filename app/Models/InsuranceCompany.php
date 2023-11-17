<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceCompany extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The user that belong to the InsuranceCompany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'insurance_company_users', 'insurance_company_id', 'user_id');
    }

    /**
     * Get all of the insuranceRequests for the InsuranceCompany
     */
    public function insuranceRequests(): HasMany
    {
        return $this->hasMany(InsuranceRequest::class);
    }

    /**
     * Get all of the insuranceReports for the InsuranceCompany
     */
    public function insuranceReports(): HasMany
    {
        return $this->hasMany(InsuranceReport::class);
    }

    /**
     * Get the country that owns the InsuranceCompany
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
