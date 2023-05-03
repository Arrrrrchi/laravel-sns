<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Providers\RouteServiceProvider;

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
                ->intended('/')
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

    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        // Googleから取得したユーザー情報
        $providerUser = Socialite::driver($provider)->stateless()->user();

        // Googleのメールアドレスをもとにユーザーモデルを取得
        $user = User::where('email', $providerUser->getEmail())->first();

        // $userがnullでなければログイン
        if ($user) {
            Auth::guard()->login($user, true); // login()の第二引数をtrueにすると、ログアウトしない限りログイン状態を維持する
            return $this->sendLoginResponse($request);
        }  

        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token,
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

}
