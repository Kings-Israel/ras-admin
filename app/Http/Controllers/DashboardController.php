<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use App\Models\UserWarehouse;
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

        // Define all data needed for the dashboard
        $warehouses_count = 0;
        $products_count = 0;
        $warehouses_count = 0;
        $warehouses = [];
        $buyers_count = 0;
        $vendors_count = 0;
        $drivers_count = 0;
        $total_users_count = 0;
        $users_registered_in_current_month = 0;
        $users_registered_in_previous_month = 0;
        $users_registration_diiference = 0;
        $user_registration_rate = 0;
        $user_registration_direction = '';
        // User Registration Rate
        $user_registration_rate_graph_data = [];
        // Vendor Registration Rate
        $vendor_registration_rate_graph_data = [];
        // Countries
        $countries = [];

        // Storage Requests
        $pending_storage_requests = 0;
        $approved_storage_requests = 0;

        $orders_on_delivery_in = 0;
        $orders_on_delivery_out = 0;

        $total_stocklift_requests = 0;

        $users_registered_in_current_month = User::whereHas('roles', function ($query) {$query->where('name', 'buyer')->orWhere('name', 'vendor');})->whereMonth('created_at', now())->count();
        $users_registered_in_previous_month = User::whereHas('roles', function ($query) {$query->where('name', 'buyer')->orWhere('name', 'vendor');})->whereMonth('created_at', now()->subMonth())->count();
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

        $total_users_count = User::whereHas('roles', function ($query) {
                            $query->where('name', '!=', 'admin');
                        })
                        ->count();

        $buyers_count = User::whereHas('roles', function ($query) {
                            $query->where('name', '=', 'buyer');
                        })
                        ->count();

        $vendors_count = User::whereHas('roles', function ($query) {
                            $query->where('name', '=', 'vendor');
                        })
                        ->count();

        foreach ($months as $month) {
            $users_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'buyer'); })->count();
            array_push($user_registration_rate_graph_data, $users_monthly);
        }

        foreach ($months as $month) {
            $vendors_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'vendor'); })->count();
            array_push($vendor_registration_rate_graph_data, $vendors_monthly);
        }

        $warehouses = Warehouse::with('users', 'products', 'country', 'city')->get();
        $warehouses_count = $warehouses->count();
        $products_count = Product::count();

        $country_colors = [
            'col-orange',
            'col-lime',
            'col-purple',
            'col-pink',
            'col-grey',
            'col-green',
            'col-black',
            'col-magenta',
            'col-yellow',
            'col-blue',
        ];

        $countries = Country::withCount('warehouses', 'businesses')
                            ->with('warehouses', 'businesses', 'cities')
                            ->orderBy('warehouses_count', 'DESC')
                            ->get()
                            ->take(9)
                            ->each(function ($country, $key) use ($country_colors) {
                                $country->color = $country_colors[$key];
                            });

        return view('dashboard', [
            'breadcrumbs' => [
                'Dashboard' => route('dashboard'),
            ],
            'months' => $months_formatted,
            'total_users_count' => $total_users_count,
            'buyers_count' => $buyers_count,
            'vendors_count' => $vendors_count,
            'user_registration_rate' => $user_registration_rate,
            'user_registration_direction' => $user_registration_direction,
            'user_registration_rate_graph_data' => $user_registration_rate_graph_data,
            'vendor_registration_rate_graph_data' => $vendor_registration_rate_graph_data,
            'warehouses' => $warehouses,
            'warehouses_count' => $warehouses_count,
            'products_count' => $products_count,
            'countries' => $countries,
        ]);
    }
}
