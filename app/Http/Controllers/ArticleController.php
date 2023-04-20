<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Providers\RouteServiceProvider;


class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

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

    public function edit (Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update (ArticleRequest $request, Article $article)
    {

        $article->fill($request->all())->save();

        return redirect()
            ->route('articles.index')
            ->with([
                'message' => '更新しました',
            ]);

    }

    public function destroy (Article $article)
    {
        $article->delete();
        return redirect()
            ->route('articles.index')
            ->with([
                'message' => '記事を削除しました'
            ]);
    }

    public function show (Article $article)
    {
        return view('articles.show', compact('article'));
    }
}
