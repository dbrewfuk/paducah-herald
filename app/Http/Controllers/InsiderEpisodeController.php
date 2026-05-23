<?php

namespace App\Http\Controllers;

use App\Models\InsiderEpisode;

class InsiderEpisodeController extends Controller
{
    public function index()
    {
        $episodes = InsiderEpisode::published()
            ->orderBy('publish_start_date', 'desc')
            ->get();

        return view('site.insiderEpisode', compact('episodes'));
    }

    public function show(string $slug)
    {
        $episode = InsiderEpisode::forSlug($slug)->first();

        if (! $episode || ! $episode->published) {
            abort(404);
        }

        $otherEpisodes = InsiderEpisode::published()
            ->where('id', '!=', $episode->id)
            ->orderBy('publish_start_date', 'desc')
            ->take(5)
            ->get();

        return view('site.insiderEpisode', compact('episode', 'otherEpisodes'));
    }
}
