<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserWarehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        if (auth()->user()->role=='Manager'){
            $warehouse=UserWarehouse::where('user_id', auth()->user()->id)->first();
            if ($warehouse)
            $products = Product::where('warehouse_id',$warehouse->warehouse_id)->with('category','business.user', 'warehouse.country',)->get();
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
            $product = Product::where('id',$id)->with('category','business.user', 'warehouse.country',)->get();
            info($product);
        return response()->json([
            "success" => true,
            "status" => 200,
            "product"=>$product
        ]);
    }
}
