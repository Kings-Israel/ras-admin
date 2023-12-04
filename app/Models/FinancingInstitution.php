<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;

class FinancingInstitution extends Model
{
    use HasFactory, Notifiable, Messageable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The users that belong to the FinancingInstitution
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'financing_institution_users', 'financing_institution_id', 'user_id');
    }

    /**
     * Get the country that owns the FinancingInstitution
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the FinancingInstitution
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all of the financingRequests for the FinancingInstitution
     */
    public function financingRequests(): HasMany
    {
        return $this->hasMany(FinancingRequest::class);
    }

    /**
     * Get all of the orderFinancings for the FinancingInstitution
     */
    public function orderFinancings(): HasMany
    {
        return $this->hasMany(OrderFinancing::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(CompanyDocument::class, 'documenteable');
    }
}
