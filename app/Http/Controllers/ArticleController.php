<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function show(string $slug)
    {
        $article = Article::forSlug($slug)->with('section')->first();

        if (! $article || ! $article->published) {
            abort(404);
        }

        $relatedArticles = collect();
        if ($article->section_id) {
            $relatedArticles = Article::published()
                ->where('section_id', $article->section_id)
                ->where('id', '!=', $article->id)
                ->orderBy('publish_start_date', 'desc')
                ->take(5)
                ->get();
        }

        return view('article', compact('article', 'relatedArticles'));
    }
}
