<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function show (string $name)
    {
        $user = User::where('name', $name)->first();
        $articles = $user->articles->sortByDesc('create_at');

        return view('user.show', compact('user', 'articles'));
    }

    public function likes(string $name)
    {
        $user = User::where('name', $name)->first();
        $articles = $user->likes->sortByDesc('created_at');

        return view('user.likes', compact('user', 'articles'));
    }

    public function follow(Request $request, string $name)
    {
        // 表示しているユーザーの情報
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }
        
        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }
        
        $request->user()->followings()->detach($user);

        return['name' => $name];
    }

}
