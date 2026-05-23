<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\GameScore;
use App\Models\Section;

class SectionController extends Controller
{
    public function show(string $slug)
    {
        $section = Section::forSlug($slug)->first();

        if (! $section || ! $section->published) {
            abort(404);
        }

        $articles = Article::published()
            ->where('section_id', $section->id)
            ->orderBy('publish_start_date', 'desc')
            ->paginate(10);

        // Pass scores to the Sports section
        $scores = null;
        if (strtolower($section->title) === 'sports') {
            $scores = GameScore::where('published', true)
                ->orderByRaw("CASE status WHEN 'final' THEN 0 WHEN 'upcoming' THEN 1 ELSE 2 END")
                ->orderBy('game_date', 'desc')
                ->limit(20)
                ->get();
        }

        return view('site.section', compact('section', 'articles', 'scores'));
    }
}
