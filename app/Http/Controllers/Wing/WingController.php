<?php

namespace App\Http\Controllers\Wing;

use App\Http\Controllers\Controller;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use App\Models\Wing;
use App\Models\WingLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wings.wings.index',[
            'page' => 'Warehouse Wings',
            'breadcrumbs' => [
                'Wings' => route('wings.index')
            ]]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userwarehouse=UserWarehouse::where('user_id', auth()->user()->id)->first();
        $warehouse = Warehouse::find($userwarehouse->warehouse_id);
        if ($warehouse) {
            $uwarehouse=$warehouse;
        }else{
            return redirect()->back()->with('error', 'Something went wrong, could not find warehouse assigned!!');
        }
        $wings=Wing::with('locations')->get();
        return view('wings.wings.create', [
            'page' => 'Create Wing',
            'breadcrumbs' => [
                'WingsCreate' => route('wings.create')
            ],
            'warehouse' => $uwarehouse,'wings'=>$wings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wingname' => 'required|string|unique:wings,wingname|max:255',
            'warehouse_id' => 'required|exists:warehouses,id',
            'capacity' => [
                'numeric',
                'max:' . $request->input('wcapacity'),
            ],
            'wcapacity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $wing = Wing::create([
            'wingname' => $request->input('wingname'),
            'description' => $request->input('description'),
            'warehouse_id' => $request->input('warehouse_id'),
            'capacity' =>$request->input('wcapacity'),
            'wunit' => $request->input('wunit'),
        ]);
        $locationsData = $request->input('locations', []);
        foreach ($locationsData as $locationData) {
            WingLocation::create([
                'location_name' => $locationData['name'],
                'wing_id' => $wing->id,
                'capacity' => $request->input('capacity'),
                'lunit' => $request->input('unit'),
            ]);
        }

        return redirect()->back()->with('success', 'Wing and location(s) created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wing $wing, Warehouse $warehouse)
    {
        $locations = $wing->locations;
        return view('wings.wings.show',[
            'page' => 'Warehouse Wing Locations',
            'breadcrumbs' => [
                'Wings' => route('wing.locations')
            ],
            'wing'=>$wing, 'locations'=>$locations, 'warehouse'=>$warehouse]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
