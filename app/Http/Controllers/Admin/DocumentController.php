<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Document;
use App\Models\RequiredDocumentPerCountry;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::withCount('countries')->with('countries')->get();
        $countries = Country::orderBy('name', 'ASC')->get();

        return view('documents.index', [
            'breadcrumbs' => [
                'Documents' => route('documents.index')
            ],
            'documents' => $documents,
            'countries' => $countries,
        ]);
    }

    public function store(Request $request)
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

    public function edit(Document $document)
    {
        return view('documents.edit', [
            'breadcrumbs' => [
                'Documents' => route('documents.index'),
                'Edit Document' => route('documents.edit', $document)
            ],
            'countries' => Country::orderBy('name', 'ASC')->get(),
            'document' => $document->load('countries')
        ]);
    }

    public function update(Request $request, Document $document)
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

        return redirect()->route('documents.index');
    }

    public function delete(Document $document)
    {
        $document->delete();

        toastr()->success('', 'Document Delete Successfully');

        return back();
    }
}
