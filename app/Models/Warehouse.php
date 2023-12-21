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

class Warehouse extends Model
{
    use HasFactory, Notifiable, Messageable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the country that owns the Warehouse
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns the Warehouse
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * The users that belong to the Warehouse
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_warehouses', 'warehouse_id', 'user_id');
    }

    /**
     * Get all of the products for the Warehouse
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orderRequests(): MorphMany
    {
        return $this->morphMany(OrderRequest::class, 'requesteable');
    }

    public function wings()
    {
        return $this->hasMany(Wing::class);
    }

    public function productReleaseRequests(): HasMany
    {
        return $this->hasMany(ReleaseProductRequest::class);
    }
}
