<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

        return view('site.section', compact('section', 'articles'));
    }
}
