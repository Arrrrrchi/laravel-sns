<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
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
        $articles = Article::all()->sortByDesc('created_at')->load('user','likes', 'tags');
        return view('articles.index', ['articles' => $articles]);
    }

    public function create ()
    {
        $allTagNames = Tag::all()->pluck('name')->toArray();
        return view('articles.create', compact('allTagNames'));
    }

    public function store (ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();

        $request->tags->each(function ($tagName) use ($article){
            $tag = Tag::firstOrCreate(['name' => $tagName]); //データベースに登録されていなければ登録
            $article->tags()->attach($tag);
        });

        return redirect(RouteServiceProvider::HOME);
    }

    public function edit (Article $article)
    {
        $tagNames = $article->tags->pluck('name')->toArray();
        return view('articles.edit', compact('article', 'tagNames'));
    }

    public function update (ArticleRequest $request, Article $article)
    {

        $article->fill($request->all())->save();

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

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
        return view('articles.show', ['article' => $article]);
    }

    /* いいねした時 */
    public function like (Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];

    }

    /* いいね外した時 */
    public function unlike (Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];

    }

}
