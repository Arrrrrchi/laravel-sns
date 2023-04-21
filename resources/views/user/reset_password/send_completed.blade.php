@extends('app')

@section('title', 'パスワード再設定メール送信完了')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
                <h1 class="text-center"><a class="text-dark" href="/">memo</a></h1>
                <div class="card mt-3">
                <div class="card-body text-center">
                    <h2 class="h3 card-title text-center mt-2">パスワード再設定メールの送信が完了しました</h2>
                    <a href="{{ route('admin.login') }}">TOPへ</a>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

