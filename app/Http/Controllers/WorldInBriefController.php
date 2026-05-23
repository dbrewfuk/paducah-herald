<?php

namespace App\Http\Controllers;

use App\Models\WorldInBrief;

class WorldInBriefController extends Controller
{
    public function index()
    {
        $briefs = WorldInBrief::published()
            ->orderBy('publish_start_date', 'desc')
            ->get();

        $latestBrief = $briefs->first();

        return view('site.worldInBrief', compact('briefs', 'latestBrief'));
    }
}
