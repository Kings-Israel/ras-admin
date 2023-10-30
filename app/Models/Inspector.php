<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inspector extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone_number', 'country_id'];

    /**
     * The users that belong to the Inspector
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inspector_users', 'inspector_id', 'user_id');
    }

    /**
     * Get the country that owns the Inspector
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
