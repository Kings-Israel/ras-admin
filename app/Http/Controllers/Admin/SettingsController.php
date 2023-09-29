<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Document;
use App\Models\MeasurementUnit;
use App\Models\RequiredDocumentPerCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name', 'ASC')->get();

        return view('settings.index', [
            'page' => 'Settings',
            'breadcrumbs' => [
                'Settings' => route('settings.index')
            ],
            'countries' => $countries,
        ]);
    }

    public function createCountry(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        Country::create($request->all());

        toastr()->success('', 'Country created successfully');

        return redirect()->route('settings.index');
    }

    public function editCountry(Country $country)
    {
        return view('settings.country.edit', [
            'page' => 'Edit Country',
            'breadcrumbs' => [
                'Settings' => route('settings.index'),
                'Edit Country' => route('settings.country.edit', ['country' => $country])
            ],
            'country' => $country->load('cities')
        ]);
    }

    public function updateCountry(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        $country->update($request->all());

        toastr()->success('', 'Country updated successfully');

        return back();
    }

    public function deleteCountry(Request $request, Country $country)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            toastr()->error('', 'Cannot perform this action. Invalid password');

            return redirect()->route('settings.index');
        }

        $country->delete();

        toastr()->success('', 'Country deleted successfully');

        return redirect()->route('settings.index');
    }

    public function storeCity(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
        ]);

        City::create([
            'country_id' => $country->id,
            'name' => $request->name,
            'latitude' => $request->latitude != '' ? $request->latitude : NULL,
            'longitude' => $request->longitude != '' ? $request->longitude : NULL,
        ]);

        toastr()->success('', 'City created successfully');

        return back();
    }

    public function updateCity(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $city->update([
            'name' => $request->name,
            'latitude' => $request->latitude != '' ? $request->latitude : $city->latitude,
            'longitude' => $request->longitude != '' ? $request->longitude : $city->longitude,
        ]);

        toastr()->success('', 'City updated successfully');

        return back();
    }

    public function deleteCity(City $city)
    {
        $city->delete();

        toastr()->success('', 'City deleted successfully');

        return back();
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        toastr()->success('', 'Category created successfully');

        return redirect()->route('settings.index');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $category->update($request->all());

        toastr()->success('', 'Category updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteCategory(Request $request, Category $category)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            toastr()->error('', 'Cannot perform this action. Incorrect password');

            return redirect()->route('settings.index');
        }

        $category->delete($request->Category_id);

        toastr()->success('', 'Category deleted successfully');

        return redirect()->route('settings.index');
    }

    public function documentStore(Request $request)
    {
        $request->validate([
            'document_name' => ['required', 'string'],
            'expiry_date_required' => ['required']
        ]);

        $document = Document::create([
            'name' => $request->document_name,
            'requires_expiry_date' => $request->expiry_date_required === 'true' ? true : false,
        ]);

        if (collect($request->required_countries)->count() == 0 || collect($request->required_countries)->contains("all")) {
            RequiredDocumentPerCountry::create([
                'document_id' => $document->id,
            ]);
        } else {
            collect($request->required_countries)->each(function($country) use ($document) {
                RequiredDocumentPerCountry::create([
                    'document_id' => $document->id,
                    'country_id' => $country
                ]);
            });
        }

        toastr()->success('', 'Document Saved Successfully');

        return back();
    }

    public function editDocument(Document $document)
    {
        return view('documents.edit', [
            'breadcrumbs' => [
                'Settings' => route('settings.index'),
                'Edit Document' => route('settings.document.edit', $document)
            ],
            'countries' => Country::orderBy('name', 'ASC')->get(),
            'document' => $document->load('countries')
        ]);
    }

    public function updateDocument(Request $request, Document $document)
    {
        $request->validate([
            'document_name' => ['required', 'string'],
            'expiry_date_required' => ['required']
        ]);
        $document->update([
            'name' => $request->document_name,
            'requires_expiry_date' => $request->expiry_date_required === 'true' ? true : false,
        ]);

        RequiredDocumentPerCountry::where('document_id', $document->id)->delete();

        if (collect($request->updated_countries)->count() == 0 || collect($request->updated_countries)->contains("all")) {
            RequiredDocumentPerCountry::create([
                'document_id' => $document->id,
            ]);
        } else {
            collect($request->updated_countries)->each(function($country) use ($document) {
                RequiredDocumentPerCountry::create([
                    'document_id' => $document->id,
                    'country_id' => $country
                ]);
            });
        }

        toastr()->success('', 'Document Updated Successfully');

        return redirect()->route('settings.index');
    }

    public function deleteDocument(Document $document)
    {
        $document->delete();

        toastr()->success('', 'Document Deleted Successfully');

        return redirect()->route('settings.index');
    }

    public function updateUnit(Request $request, MeasurementUnit $unit)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $unit->update([
            'name' => $request->name,
            'abbrev' => $request->has('abbrev') && $request->abbrev != '' ? $request->abbrev : $unit->abbrev,
        ]);

        toastr()->success('', 'Unit updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteUnit(MeasurementUnit $unit)
    {
        $unit->delete();

        toastr()->success('', 'Unit deleted Successfully');

        return redirect()->route('settings.index');
    }
}
