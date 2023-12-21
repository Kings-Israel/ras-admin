<?php

namespace App\Policies;

use App\Models\InspectingInstitution;
use App\Models\InspectionReport;
use App\Models\OrderRequest;
use App\Models\User;

class InspectionReportPolicy
{
    public function create(User $user, OrderRequest $orderRequest): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('create inspection report') && $inspection_institutions->contains($orderRequest->requesteable_id) && $orderRequest->requesteable_type == InspectingInstitution::class) {
            return true;
        }

        return false;
    }

    public function view(User $user, InspectionReport $inspection_report): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('view inspection report') && $inspection_institutions->contains($inspection_report->inspector_id)) {
            return true;
        }

        return false;
    }

    public function update(User $user, InspectionReport $inspection_report): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('update inspection report') && $inspection_institutions->contains($inspection_report->inspector_id)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, InspectionReport $inspection_report): bool
    {
        $inspection_institutions = $user->inspectors->pluck('id');

        if ($user->hasPermissionTo('delete inspection report') && $inspection_institutions->contains($inspection_report->inspector_id)) {
            return true;
        }

        return false;
    }
}
