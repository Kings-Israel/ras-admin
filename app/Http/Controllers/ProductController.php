<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductMedia as ModelsProductMedia;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use App\Models\WarehouseRestocking;
use App\Models\Wing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $user = auth()->user();
        // if (Auth::check() && Auth::user()->hasRole('warehouse manager')){
        //     $userwarehouse=UserWarehouse::where('user_id',$user->id)->first();
        //     $warehouse = Warehouse::where('id',$userwarehouse->warehouse_id)->first();
        //     if ($warehouse) {
        //         $warehouse=$warehouse->first();
        //         $products = WarehouseProduct::where('warehouse_products.warehouse_id', $warehouse->id)
        //             ->join('products', 'warehouse_products.product_id', '=', 'products.id')
        //             ->with('warehouse',
        //                 'product.category',
        //                 'product.business.user',
        //                 'product.warehouses.country',
        //                 'winglocation',
        //                 'product.media'
        //             )->get(['warehouse_products.*']);
        //         return view('products.index', [
        //             'page' => 'Products',
        //             'breadcrumbs' => [
        //                 'Products' => route('products')
        //             ],
        //             'products'=>$products,
        //         ]);

        //     } else {
        //         $products = [];
        //     }
        // }else{
        //     $products = Product::with('category','business.user', 'warehouses.country','media')->get();
        // }

        $products = Product::with('warehouses', 'business', 'media', 'category')->get();

        return view('products.index', [
            'page' => 'Products',
            'breadcrumbs' => [
                'Products' => route('products.index')
            ],
            'products' => $products
        ]);
    }

    public function details(Product $product)
    {
        $product->load('category', 'business.user', 'warehouses.country', 'location.wing', 'media');

        return view('products.details', [
            'page' => 'Product',
            'breadcrumbs' => [
                'Products' => route('products.index'),
                'Details' => route('products.details', ['product' => $product])
            ],
            'product' => $product
        ]);
    }

    public function getWingLocations($wingId)
    {
        $wing = Wing::findOrFail($wingId);
        $locations = $wing->locations;
        return response()->json($locations);
    }

    public function create()
    {
        // $userwarehouse = UserWarehouse::where('user_id', auth()->user()->id)->first();
        // $warehouse = Warehouse::find($userwarehouse->warehouse_id);
        // $wings = Wing::where('warehouse_id', $warehouse->id)->with('locations')->get();
        $warehouses = auth()->useR()->hasRole('admin') ? Warehouse::with('wings')->get() : auth()->user()->warehouses->load('wings');

        if ($warehouses->count() <= 0) {
            toastr()->error('', 'Must be a warehouse manager to add product');
            return back();
        }

        return view('products.create', [
            'page' => 'Create Product',
            'breadcrumbs' => [
                'Product' => route('products.create')
            ],
            'business'=>Business::all(),
            'categories' => Category::all(),
            'warehouses' => $warehouses,
            'units' => MeasurementUnit::all(),
            'shapes' => collect(['Rectangle', 'Circle', 'Square', 'Rhombus', 'Sphere']),
            'colors' => collect(['Red', 'Green', 'Blue', 'Purple', 'Yellow', 'Maroon', 'Orange', 'Gray', 'Magenta', 'Teal', 'Gold', 'White', 'Black']),
            'usages' => collect(['Home Decor', 'Office Decor']),
            'regions' => collect(['Africa', 'USA', 'Europe', 'Middle East', 'Asia', 'Other']),
            'currencies' => collect(['USD', 'EUR', 'GBP', 'KSH', 'JPY']),
        ]);
    }

    public function restock($product_id)
    {
        $userwarehouse = UserWarehouse::where('user_id', auth()->user()->id)->first();
        $warehouse = Warehouse::find($userwarehouse->warehouse_id);
        $product=Product::findOrFail($product_id);
        $current_quantity=0;
        if ($product){
            $current_quantity=WarehouseProduct::where('product_id',$product_id)->where('warehouse_id', $warehouse->id)->select('quantity')->first();
        }
        $product = Product::findOrFail($product_id);
            return view('products.restock', [
                'page' => 'Restock Product',
                'breadcrumbs' => [
                    'Product' => route('products.index')
                ],
                'warehouse' => $warehouse,
                'product'=>$product,
                'current_quantity'=>$current_quantity
                ]);
        }


    public function store(Request $request)
    {
        $request->validate([
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
        ]);

        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->input('name'),
                'category_id' => $request->input('category'),
                'price' => $request->input('price'),
                'min_price' => $request->input('min_price'),
                'max_price' => $request->input('max_price'),
                'max_order_quantity' => $request->input('max_quantity_order').' '.$request->input('max_quantity_order_unit'),
                'min_order_quantity' => $request->input('min_quantity_order').' '.$request->input('min_quantity_order_unit'),
                'color' => $request->input('color'),
                'shape' => $request->input('shape'),
                'brand' => $request->input('brand'),
                'material' => $request->input('material'),
                'place_of_origin' => $request->input('place_of_origin'),
                'description' => $request->description,
                'model_number' => $request->model_number,
                'is_available' => $request->product_availability,
                'regional_featre' => $request->regional_feature,
                'bin' => $request->bin,
                'is_warehouse_product'=>1
            ]);

            $product_id=$product->id;

            WarehouseProduct::create([
                'warehouse_id'=>$request->warehouse,
                'product_id'=>$product_id,
                'quantity'=>$request->initial_quantity,
                'wing_locations_id'=>$request->wingLocation,
                'min_quantity'=>$request->min_quantity
            ]);

            if ($request->initial_quantity >0){
                WarehouseRestocking::create([
                    'product_id' => $product_id,
                    'warehouse_id'=>$request->input('warehouse'),
                    'user_id'=>auth()->user()->id,
                    'quantity'=>$request->initial_quantity,
                ]);
            }

            foreach ($request->images as $image) {
                ProductMedia::create([
                    'product_id' => $product_id,
                    'file' => pathinfo($image->store('product', 'warehouse'), PATHINFO_BASENAME),
                    'type' => 'image',
                ]);
            }

            if ($request->hasFile('video')) {
                ProductMedia::create([
                    'product_id' => $product_id,
                    'file' => pathinfo($request->video->store('product', 'warehouse'), PATHINFO_BASENAME),
                    'type' => 'video',
                ]);
            }

            DB::commit();

            activity()->causedBy(auth()->user())->performedOn($product)->log('add a new product');

            toastr()->success('', 'Product added successfully');

            return redirect()->route('products.index');

        }  catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding product: ' . $e->getMessage());
            toastr()->error('', 'An error occurred while adding the product');
            return redirect()->route('products.index');
        }
    }

    public function restocking(Request $request)
    {
        try {
            DB::beginTransaction();

            $userwarehouse = UserWarehouse::where('user_id', auth()->user()->id)->first();
            $warehouse = Warehouse::find($userwarehouse->warehouse_id);
            $product_id = $request->product_id;
            $warehouseProduct = WarehouseProduct::where([
                'warehouse_id' => $warehouse->id,
                'product_id' => $product_id,
            ])->first();

            if ($warehouseProduct) {
                $warehouseProduct->update([
                    'quantity' => $request->quantity,
                ]);
            }
            WarehouseRestocking::create([
                'product_id' => $product_id,
                'warehouse_id'=>$warehouse->id,
                'user_id'=>auth()->user()->id,
                'quantity'=>$request->quantity,

            ]);

            DB::commit();
                $product=Product::find($product_id);
            activity()->causedBy(auth()->user())->performedOn($product)->log('restocked product');

            toastr()->success('', 'Product restocked successfully');

            return redirect()->route('products');

        }  catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding product: ' . $e->getMessage());
            toastr()->error('', 'An error occurred while restocking the product');
            return redirect()->route('products');
        }
    }
}
