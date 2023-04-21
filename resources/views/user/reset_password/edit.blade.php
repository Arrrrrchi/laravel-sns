@extends('app')

@section('title', '新パスワード入力フォーム')

@section('content')
<div class="container">
    <div class="row">
        <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
            <h1 class="text-center"><a class="text-dark" href="/">memo</a></h1>
            <div class="card mt-3">
            <div class="card-body text-center">
                <h2 class="h3 card-title text-center mt-2">新しいパスワードを設定</h2>
                <form method="POST" action="{{ route('password_reset.update') }}">
                    @csrf
                    <input type="hidden" name="reset_token" value="{{ $userToken->token }}">
                    <div class="md-form">
                        <label for="password" class="h3 card-title text-center mt-2">新しいパスワード</label>
                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'incorrect' : '' }}">
                        @error('token')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md-form">
                        <label for="password_confirmation" class="h3 card-title text-center mt-2">新しいパスワード(再入力)</label>
                        <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'incorrect' : '' }}">
                    </div>
                    <button type="submit" class="btn btn-block blue-gradient mt-2 mb-2" >パスワードを再設定</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection