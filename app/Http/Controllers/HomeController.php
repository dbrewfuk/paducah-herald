<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->orderBy('publish_start_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->with('medias')
            ->get();

        $featured = $articles->first();
        $rest = $articles->skip(1);

        return view('home', compact('featured', 'rest'));
    }
}
