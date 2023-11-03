<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Country;
use App\Models\FinancingRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use VisitLog;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        // Get past 12 months
        $months = [];

        for ($i = 12; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonth($i);
            $year = Carbon::today()->startOfMonth()->subMonth($i)->format('Y');
            array_push($months, $month);
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
        $total_buyers_count = 0;
        $total_vendors_count = 0;
        $total_businesses_count = 0;
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

        // Top Businesses
        $top_businesses = [];

        // Top Selling Products
        $top_selling_products = [];

        // Top Categories by products
        $top_categories_by_number_of_products = [];

        // Top Categories by orders
        $top_categories_by_number_of_orders = [];

        // Storage Requests
        $pending_storage_requests = 0;
        $approved_storage_requests = 0;

        $orders_on_delivery_in = 0;
        $orders_on_delivery_out = 0;

        $total_stocklift_requests = 0;

        // Financing Requests
        $financing_requests_count = 0;

        // Site visits log
        $site_visits_series = [];

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

        $total_buyers_count = User::whereHas('roles', function ($query) {
                            $query->where('name', '=', 'buyer');
                        })
                        ->count();

        $total_vendors_count = User::whereHas('roles', function ($query) {
                            $query->where('name', '=', 'vendor');
                        })
                        ->count();

        $total_businesses_count = Business::count();

        $financing_requests_count = FinancingRequest::count();

        foreach ($months as $month) {
            $users_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'buyer'); })->count();
            array_push($user_registration_rate_graph_data, $users_monthly);
        }

        foreach ($months as $month) {
            $vendors_monthly = User::whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->whereHas('roles', function($query) { $query->where('name', 'vendor'); })->count();
            array_push($vendor_registration_rate_graph_data, $vendors_monthly);
        }

        $all_visits_log = VisitLog::all();

        $visit_log = [];
        $visits_bandwidth = 0;
        foreach ($months as $month) {
            $monthly_visits = $all_visits_log->whereBetween('created_at', [Carbon::parse($month)->startOfMonth(), Carbon::parse($month)->endOfMonth()])->count();
            array_push($visit_log, $monthly_visits);
            $visits_bandwidth += $monthly_visits;
        }

        $current_month_site_visits = $all_visits_log->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $prev_month_site_visits = $all_visits_log->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
        $site_visit_difference = $current_month_site_visits - $prev_month_site_visits;
        if ($site_visit_difference <= 0) {
            $site_visits_rate = 0;
        } else {
            $site_visits_rate = ceil(($site_visit_difference / ($current_month_site_visits - $prev_month_site_visits)) * 100);
        }

        if ($prev_month_site_visits < $current_month_site_visits) {
            $site_visits_direction = 'higher';
        } else {
            $site_visits_direction = 'lower';
        }

        $site_visits_series = [
            'visit_log' => $visit_log,
            'visits_bandwidth' => $visits_bandwidth,
            'site_visits_rate' => $site_visits_rate,
            'site_visits_direction' => $site_visits_direction,
            'current_month_site_visits' => $current_month_site_visits
        ];


        $warehouses = Warehouse::with('users', 'products', 'country', 'city')->get();
        $warehouses_count = $warehouses->count();
        $products_count = Product::count();

        $all_categories = Category::withCount('products')
                                    ->orderBy('products_count', 'DESC')
                                    ->get();

        // Product Per Category
        $product_per_category = [];
        $product_percent_per_category = [];
        $categories_formatted = [];
        $category_colors = [];
        $colors = [
            '#ffe700', '#2D4356',
            '#00d4bd', '#FCAEAE',
            '#826bf8', '#4C4B16',
            '#2b9bf4', '#FF90BB',
            '#FFA1A1', '#FF2171',
            '#3F2E3E', '#001C30',
            '#A78295', '#176B87',
            '#8CC0DE', '#3AA6B9',
            '#FFD9C0', '#0A6EBD',
            '#1D5B79', '#F86F03',
            '#468B97', '#525FE1',
            '#EF6262', '#A0C49D',
            '#78C1F3', '#213363',
            '#9BE8D8', '#17594A',
            '#1A5D1A', '#D3D04F',
            '#F1C93B', '#22A699',
            '#4E4FEB', '#E966A0',
            '#068FFF', '#6554AF',
            '#AAC8A7', '#9BCDD2',
            '#862B0D', '#FF8551',
            '#4A55A2', '#1F6E8C',
            '#7895CB', '#84A7A1',
            '#6527BE', '#F2BE22',
            '#45CFDD', '#40128B',
        ];
        $highest_category_id = '';
        $highest_category_name = '';
        $highest_category_percent = '';
        $highest_category = 0;
        foreach ($all_categories as $key => $category) {
            $product_count = Product::where('category_id', $category->id)->count();
            if ($product_count > 0) {
                array_push($product_per_category, $product_count);
                array_push($categories_formatted, $category->name);
                array_push($category_colors, $colors[rand(0, count($colors) - 1)]);
                array_push($product_percent_per_category, ceil((Product::where('category_id', $category->id)->count() / $products_count) * 100));
            }
            if ($product_count > $highest_category) {
                $highest_category = $product_count;
                $highest_category_name = $category->name;
                $highest_category_id = $category->id;
            }
            if ($key == 2) {
                break;
            }
        }

        if ($products_count > 0) {
            $highest_category_percent = (string) ceil((Product::where('category_id', $highest_category_id)->count() / $products_count) * 100).'%';
        }

        $product_categories_ratio = [
            'series' => $product_per_category,
            'labels' => $categories_formatted,
            'percentage' => $product_percent_per_category,
            'colors' => $category_colors,
            'highest_category_name' => $highest_category_name,
            'highest_category_percent' => $highest_category_percent,
        ];

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
            'total_buyers_count' => $total_buyers_count,
            'total_vendors_count' => $total_vendors_count,
            'total_businesses_count' => $total_businesses_count,
            'user_registration_rate' => $user_registration_rate,
            'user_registration_direction' => $user_registration_direction,
            'user_registration_rate_graph_data' => $user_registration_rate_graph_data,
            'vendor_registration_rate_graph_data' => $vendor_registration_rate_graph_data,
            'warehouses' => $warehouses,
            'warehouses_count' => $warehouses_count,
            'products_count' => $products_count,
            'countries' => $countries,
            'pending_storage_requests' => $pending_storage_requests,
            'approved_storage_requests' => $approved_storage_requests,
            'total_stocklift_requests' => $total_stocklift_requests,
            'product_categories_ratio' => $product_categories_ratio,
            'site_visits_series' => $site_visits_series,
            'financing_requests_count' => $financing_requests_count,
        ]);
    }
}
