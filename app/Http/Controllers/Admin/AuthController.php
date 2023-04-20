<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm ()
    {
        return view('admin.users.login');
    }

    public function login (Request $request)
    {
        // バリデーション
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ログイン検証
        if (Auth::attempt($credentials)) {
            // セッションを再生成する処理（セキュリティ対策)
            $request->session()->regenerate();

            return redirect()
                ->route('articles.index')
                ->with([
                    'message' => 'ログインしました',
                ]);
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ])->onlyInput('email');

    }

    public function logout (Request $request)
    {
        // ログアウト処理
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('articles.index')
            ->with([
                'message' => 'ログアウトしました',
            ]);
    }
}
