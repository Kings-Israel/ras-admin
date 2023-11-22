<?php

namespace App\Http\Controllers;

use App\Models\MarketingPoster;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        $marketing_posters = MarketingPoster::all();

        return view('marketing.index', [
            'page' => 'Marketing Posters',
            'breadcrumbs' => [
                'Marketing Posters' => route('marketing.index')
            ],
            'marketing_posters' => $marketing_posters
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'poster' => ['required', 'mimes:png,jpg', 'max:10000']
        ]);

        MarketingPoster::create([
            'image' => pathinfo($request->poster->store('poster', 'marketing'), PATHINFO_BASENAME),
            'description' => $request->has('description') ? $request->description : NULL,
            'description_text_color' => $request->description_text_color,
            'description_text_align' => $request->description_text_align,
            'font_size' => $request->description_font_size,
        ]);

        toastr()->success('', 'Campaign created successfully');

        return redirect()->route('marketing.index');
    }

    public function update(Request $request, MarketingPoster $marketing_poster)
    {
        $request->validate([
            'poster' => ['nullable', 'mimes:png,jpg', 'max:10000']
        ]);

        if ($request->hasFile('poster')) {
            $marketing_poster->update([
                'poster' => pathinfo($request->poster->store('poster', 'marketing'), PATHINFO_BASENAME),
            ]);
        }

        $marketing_poster->update([
            'description' => $request->has('description') ? $request->description : $marketing_poster->description,
            'description_text_color' => $request->has('description_text_color') ? $request->description_text_color : $marketing_poster->description_text_color,
            'description_text_align' => $request->has('description_text_align') ? $request->description_text_align : $marketing_poster->description_text_align,
            'font_size' => $request->has('description_font_size') ? $request->description_font_size : $marketing_poster->font_size,
        ]);

        toastr()->success('', 'Campaign updated successfully');

        return redirect()->route('marketing.index');
    }

    public function delete(MarketingPoster $marketing_poster)
    {
        $marketing_poster->delete();

        toastr()->success('', 'Campaign deleted successfully');

        return redirect()->route('marketing.index');
    }
}
