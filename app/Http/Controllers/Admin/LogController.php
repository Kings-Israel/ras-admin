<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function __invoke()
    {
        $logs = Activity::with('causer', 'subject')->get();

        return view('logs', [
            'page' => 'Activity Logs',
            'breadcrumbs' => [
                'Activity Logs' => route('logs')
            ],
            'logs' => $logs
        ]);
    }
}
