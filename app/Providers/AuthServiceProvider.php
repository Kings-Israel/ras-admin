<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\InspectionReport;
use App\Models\OrderRequest;
use App\Models\Warehouse;
use App\Policies\InspectionReportPolicy;
use App\Policies\InspectionRequestPolicy;
use App\Policies\WarehousePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        OrderRequest::class => InspectionRequestPolicy::class,
        InspectionReport::class => InspectionReportPolicy::class,
        Warehouse::class => WarehousePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        $this->registerPolicies();
    }
}
