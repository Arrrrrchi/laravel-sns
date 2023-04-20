<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Providers\RouteServiceProvider;


class ArticleController extends Controller
{
    public function index ()
    {
        $articles = Article::all()->sortByDesc('created_at');
        return view('articles.index', ['articles' => $articles]);
    }

    public function create ()
    {
        return view('articles.create');
    }

    public function store (ArticleRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        Article::create($validated);

        return redirect(RouteServiceProvider::HOME);
    }
}
