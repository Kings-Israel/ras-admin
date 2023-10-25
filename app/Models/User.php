<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($this, $token));
    }

    public function getAvatarAttribute($value)
    {
        if ($value != NULL) {
            return config('app.frontend_url').'/storage/user/avatars/'.$value;
        }
        return public_path().'/assets/images/user.png';
    }

    /**
     * The roles that belong to the User
     */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'user_warehouses', 'user_id', 'warehouse_id');
    }

    /**
     * Get the business associated with the User
     */
    public function business(): HasOne
    {
        return $this->hasOne(Business::class);
    }
}
