<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FinancingInstitution extends Model
{
    use HasFactory;

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
}
