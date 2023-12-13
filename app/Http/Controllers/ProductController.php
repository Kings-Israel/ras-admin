<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = auth()->user();
        if (Auth::check() && Auth::user()->hasRole('warehouse manager')){
            $userwarehouse=UserWarehouse::where('user_id',$user->id)->first();
            $warehouse = Warehouse::where('id',$userwarehouse->warehouse_id)->first();
            if ($warehouse) {
                $warehouse=$warehouse->first();
                $products = WarehouseProduct::where('warehouse_products.warehouse_id', $warehouse->id)
                    ->join('products', 'warehouse_products.product_id', '=', 'products.id')
                    ->with('warehouse',
                        'product.category',
                        'product.business.user',
                        'product.warehouse.country',
                        'product.location.wing'
                    )->get(['warehouse_products.*']);
                    $wings=Wing::where('warehouse_id', $warehouse->id)->with('locations')->get();
                return view('products.index', [
                    'page' => 'Products',
                    'breadcrumbs' => [
                        'Products' => route('products')
                    ],
                    'products'=>$products,
                    'wings'=>$wings,
                    'business'=>Business::all(),
                    'categories' => Category::all(),
                    'warehouse' => [$warehouse->id],
                    'units' => MeasurementUnit::all(),
                    'shapes' => collect(['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere']),
                    'colors' => collect(['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black']),
                    'usages' => collect(['Home Decor', 'Office Decor']),
                    'regions' => collect(['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other']),
                    'currencies' => collect(['USD', 'EUR', 'GBP', 'KSH', 'JPY']),
                ]);

            } else {
                $products = [];
            }
        }else{
            $products = Product::with('category','business.user', 'warehouse.country',)->get();
        }
        return view('products.index', [
            'page' => 'Products',
            'breadcrumbs' => [
                'Products' => route('products')
            ],
            'products' => $products
        ]);
    }
    public function details($id)
    {
        $product = Product::where('id', $id)
            ->with('category', 'business.user', 'warehouse.country', 'location.wing')
            ->first();
            return view('products.details', [
            'page' => 'Product',
            'breadcrumbs' => [
                'Product' => route('products')
            ],
            'product' => $product
        ]);
    }
    public function create(){
        $userwarehouse=UserWarehouse::where('user_id', auth()->user()->id)->first();
        $warehouse = Warehouse::find($userwarehouse->warehouse_id);
            return view('products.create', [
                'page' => 'Create Product',
                'breadcrumbs' => [
                    'Product' => route('product.create')
                ],
                'business'=>Business::all(),
                'categories' => Category::all(),
                'warehouse' => [$warehouse->id],
                'units' => MeasurementUnit::all(),
                'shapes' => collect(['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere']),
                'colors' => collect(['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black']),
                'usages' => collect(['Home Decor', 'Office Decor']),
                'regions' => collect(['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other']),
                'currencies' => collect(['USD', 'EUR', 'GBP', 'KSH', 'JPY']),
                ]);
        }

        public function store(Request $request){

        }
}
