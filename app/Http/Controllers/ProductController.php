<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\ProductMedia as ModelsProductMedia;
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
                'wings' => Wing::with('locations')->get(),
                'shapes' => collect(['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere']),
                'colors' => collect(['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black']),
                'usages' => collect(['Home Decor', 'Office Decor']),
                'regions' => collect(['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other']),
                'currencies' => collect(['USD', 'EUR', 'GBP', 'KSH', 'JPY']),
                ]);
        }

        public function store(Request $request){
            $this->validate= [
                'name' => ['required'],
                'category' => ['required'],
                'price' => ['required_without:min_price', 'required_without:max_price'],
                'min_price' => ['required_without:price'],
                'max_price' => ['required_without:price'],
                'min_quantity_order_unit' => ['required_with:min_quantity_order'],
                'max_quantity_order_unit' => ['required_with:max_quantity_order'],
                'description' => ['required'],
                'model_number' => ['required'],
                'images' => ['required', 'array'],
                'images.*' => ['mimes:png,jpg,jpeg', 'max:4096'],
                'video' => ['nullable', 'mimes:mp4', 'max:10000']
            ];
            $product = Product::create([
                'business_id' => auth()->user()->business->id,
                'name' => $request->input('name'),
                'category_id' => $request->input('category'),
                'price' => $request->input('price'),
                'min_price' => $request->input('min_price'),
                'max_price' => $request->input('max_price'),
                'max_order_quantity' => $request->input('max_quantity_order').' '.$request->input('max_quantity_order_unit'),
                'min_order_quantity' => $request->input('min_quantity_order').' '.$request->input('min_quantity_order_unit'),
                'color' => $request->input('color'),
                'shape' => $request->input('shape'),
                // 'usage' => $request->input('usage'],
                'brand' => $request->input('brand'),
                'material' => $request->input('material'),
                'place_of_origin' => $request->input('place_of_origin'),
                'description' => $request->description,
                'model_number' => $request->model_number,
                'is_available' => $request->product_availability,
                'regional_featre' => $request->regional_feature,
            ]);
            WarehouseProduct::create([
                'warehouse_id'=>$request->input('warehouse_code'),
                'product_id'=>$product->id,
                'quantity'=>$request->quantity,
                'wing_locations_id'=>$request->location
            ]);
            foreach ($this->images as $image) {
                ModelsProductMedia::create([
                    'product_id' => $product->id,
                    'file' => pathinfo($image->store('product', 'vendor'), PATHINFO_BASENAME),
                    'type' => 'image',
                ]);
            }

            if ($this->video) {
                ModelsProductMedia::create([
                    'product_id' => $product->id,
                    'file' => pathinfo($this->video->store('product', 'vendor'), PATHINFO_BASENAME),
                    'type' => 'video',
                ]);
            }

            activity()->causedBy(auth()->user())->performedOn($product)->log('add a new product');

            toastr()->success('', 'Product added successfully');

            return redirect()->route('products');
        }
}
