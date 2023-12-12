<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['verified_on', 'approval_status', 'rejected_approval_reason'];
    /**
     * Get the primary image
     *
     * @param  string  $value
     * @return string
     */
    public function getPrimaryCoverImageAttribute($value)
    {
        return config('app.frontend_url').'/storage/vendor/cover_image/'.$value;
    }

    /**
     * Get the primary image
     *
     * @param  string  $value
     * @return string
     */
    public function getSecondaryCoverImageAttribute($value)
    {
        if ($value) {
            return config('app.frontend_url').'/storage/vendor/cover_image/'.$value;
        }
    }

    /**
     * Get the business profile
     *
     * @param  string  $value
     * @return string
     */
    public function getBusinessProfileAttribute($value)
    {
        if ($value) {
            return config('app.frontend_url').'/storage/vendor/profile/'.$value;
        }
    }

    public function verified():bool
    {
        if ($this->verified_on) {
            return true;
        }

        return false;
    }

    /**
     * Get the user that owns the Business
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        /**
     * Get all of the documents for the Business
     */
    public function documents(): HasMany
    {
        return $this->hasMany(BusinessDocument::class);
    }

    /**
     * Get the country that owns the Business
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the Business
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all of the products for the Business
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the orders for the Business
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function resolveApprovalStatus(): string
    {
        switch ($this->approval_status) {
            case 'pending':
                return 'bg-grey p-2 rounded-lg';
                break;
            case 'approved':
                return 'bg-green p-2 rounded-lg';
                break;
            case 'rejected':
                return 'bg-red p-2 rounded-lg';
                break;
            default:
                return 'bg-grey p-2 rounded-lg';
                break;
        }
    }
}
