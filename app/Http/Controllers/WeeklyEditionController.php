<?php

namespace App\Http\Controllers;

use App\Models\WeeklyEdition;

class WeeklyEditionController extends Controller
{
    public function index()
    {
        $editions = WeeklyEdition::published()
            ->orderBy('edition_date', 'desc')
            ->get();

        return view('site.weeklyEdition', compact('editions'));
    }

    public function show(string $slug)
    {
        $edition = WeeklyEdition::forSlug($slug)->first();

        if (! $edition || ! $edition->published) {
            abort(404);
        }

        return view('site.weeklyEdition', compact('edition'));
    }
}
