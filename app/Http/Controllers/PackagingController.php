<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use App\Models\Packaging;
use Illuminate\Http\Request;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $packagings=Packaging::all();
        return view('app.packaging.index', [
            'page' => 'Packaging',
            'breadcrumbs' => [
                'Packaging' => route('packaging')
            ],
            'packagings' => $packagings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uom=MeasurementUnit::all();
        return view('app.packaging.create', [
            'page' => 'Add Packaging',
            'breadcrumbs' => [
                'Packaging' => route('packaging'),
                'Add Packaging' => route('packaging.create'),
            ],
            'uom'=>$uom
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:packagings'],
            'uom' => ['required'],
        ], [
            'name.required' => 'Please Enter Packaging Name',
            'uom.required' => 'Enter Unit of Measurement for the Package'
        ]);
        Packaging::create([
            'name' => $request->name,
            'description'=>$request->description,
            'unit_of_measurement'=>$request->uom,
        ]);
        return redirect()->route('packaging')->with('success', 'Packaging Inserted Successfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $packaging=Packaging::findOrFail($id);
        $uom=MeasurementUnit::all();
        return view('app.packaging.edit', [
            'page' => 'Edit Packaging',
            'breadcrumbs' => [
                'Packaging' => route('packaging'),
                'Edit '.$packaging->name => route('packaging.edit', ['packaging' => $packaging])
            ],
            'packaging' => $packaging,
            'uom'=>$uom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => ['required'],
            'uom' => ['required'],
        ], [
            'name.required' => 'Please Enter Packaging Name',
            'uom.required' => 'Enter Unit of Measurement for the Package'
        ]);
        $packaging = Packaging::find($id);
        if (!$packaging) {
            return redirect()->route('packaging')->with('error', 'Packaging not found');
        }

        $packaging->name = $request->name;
        $packaging->description = $request->description;
        $packaging->unit_of_measurement = $request->uom;
        $packaging->save();

        return redirect()->route('packaging')->with('success', 'Packaging updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
