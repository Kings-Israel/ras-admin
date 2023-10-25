<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        // Get past 9 months
        $months = [];
        // $days = [0, 29, 59, 89, 119, 149, 179, 209, 239];
        // $days = [239, 209, 179, 149, 119, 89, 59, 29, 0];
        $days = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0];
        foreach($days as $day) {
            array_push($months, now()->subMonths($day));
        }

        // Format months
        $months_formatted = [];
        foreach ($months as $key => $month) {
            array_push($months_formatted, Carbon::parse($month)->format('M'));
        }

        if (auth()->user()->hasRole('admin')) {
            $users_registered_in_current_month = User::whereMonth('created_at', now())->count();
            $users_registered_in_previous_month = User::whereMonth('created_at', now()->subMonth())->count();
            $users_registration_diiference = $users_registered_in_previous_month - $users_registered_in_current_month;
            if ($users_registration_diiference < 0) {
                $user_registration_rate = 0;
            } else {
                $user_registration_rate = ceil($users_registration_diiference / ($users_registered_in_previous_month + $users_registered_in_current_month) * 100);
            }

            if ($users_registered_in_previous_month < $users_registered_in_current_month) {
                $user_registration_direction = 'higher';
            } else {
                $user_registration_direction = 'lower';
            }

            $users = User::whereHas('roles', function ($query) {
                                $query->where('name', '!=', 'admin');
                            })
                            ->count();

            // User Registration Rate
            $user_registration_rate_graph_data = [];
            foreach ($months as $month) {
                $users_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'buyer'); })->count();
                array_push($user_registration_rate_graph_data, $users_monthly);
            }

            // Vendor Registration Rate
            $vendor_registration_rate_graph_data = [];
            foreach ($months as $month) {
                $vendors_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'vendor'); })->count();
                array_push($vendor_registration_rate_graph_data, $vendors_monthly);
            }

            $warehouses = Warehouse::count();
            $products = Product::count();

            return view('dashboard', [
                'breadcrumbs' => [
                    'Dashboard' => route('dashboard'),
                ],
                'months' => $months_formatted,
                'users' => $users,
                'user_registration_rate' => $user_registration_rate,
                'user_registration_direction' => $user_registration_direction,
                'user_registration_rate_graph_data' => $user_registration_rate_graph_data,
                'vendor_registration_rate_graph_data' => $vendor_registration_rate_graph_data,
                'warehouses' => $warehouses,
                'products' => $products
            ]);
        }
    }
}
