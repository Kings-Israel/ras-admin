<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;

class InspectingInstitution extends Model
{
    use HasFactory, Notifiable, Messageable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The users that belong to the InspectingInstitution
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inspector_users', 'inspector_id', 'user_id');
    }

    public function orderRequests(): MorphMany
    {
        return $this->morphMany(OrderRequest::class, 'requesteable');
    }

    public function serviceCharge(): MorphOne
    {
        return $this->morphOne(ServiceCharge::class, 'chargeable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(CompanyDocument::class, 'documenteable');
    }
}
