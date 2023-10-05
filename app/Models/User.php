<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getAvatarAttribute($value)
    {
        if ($value != NULL) {
            return config('app.frontend_url').'/storage/user/avatars/'.$value;
        }
        return public_path().'/assets/images/user.png';
    }
}
