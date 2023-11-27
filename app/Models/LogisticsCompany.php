<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;

class LogisticsCompany extends Model
{
    use HasFactory, Notifiable, Messageable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The users that belong to the LogisticsCompany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'logistics_company_users', 'logistics_company_id', 'user_id');
    }

    /**
     * Get the country that owns the LogisticsCompany
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the LogisticsCompany
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all of the deliveryRequests for the LogisticsCompany
     */
    public function deliveryRequests(): HasMany
    {
        return $this->hasMany(OrderDeliveryRequest::class);
    }
}
