<?php

namespace App\Policies;

use App\Models\InsuranceCompany;
use App\Models\InsuranceReport;
use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InsuranceReportPolicy
{
    public function create(User $user, OrderRequest $orderRequest): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('create insurance report') && $insurers->contains($orderRequest->requesteable_id) && $orderRequest->requesteable_type == InsuranceCompany::class) {
            return true;
        }

        return false;
    }

    public function view(User $user, InsuranceReport $insurance_report): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('view insurance report') && $insurers->contains($insurance_report->insurance_company_id)) {
            return true;
        }

        return false;
    }

    public function update(User $user, InsuranceReport $insurance_report): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('update insurance report') && $insurers->contains($insurance_report->insurance_company_id)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, InsuranceReport $insurance_report): bool
    {
        $insurers = $user->insuranceCompanies->pluck('id');

        if ($user->hasPermissionTo('delete insurance report') && $insurers->contains($insurance_report->insurance_company_id)) {
            return true;
        }

        return false;
    }
}
