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
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
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

    /**
     * The financingInstitutions that belong to the User
     */
    public function financingInstitutions(): BelongsToMany
    {
        return $this->belongsToMany(FinancingInstitution::class, 'financing_institution_users', 'user_id', 'financing_institution_id');
    }

    /**
     * The inspectors that belong to the User
     */
    public function inspectors(): BelongsToMany
    {
        return $this->belongsToMany(InspectingInstitution::class, 'inspector_users', 'user_id', 'inspector_id');
    }

    /**
     * The logisticsCompanies that belong to the User
     */
    public function logisticsCompanies(): BelongsToMany
    {
        return $this->belongsToMany(LogisticsCompany::class, 'logistics_company_users', 'user_id', 'logistics_company_id');
    }

    /**
     * The insuranceCompany that belong to the InsuranceCompanyUser
     */
    public function insuranceCompanies(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceCompany::class, 'insurance_company_users', 'user_id', 'insurance_company_id');
    }
}
