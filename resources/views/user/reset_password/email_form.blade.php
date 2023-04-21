@extends('app')

@section('title', 'パスワード再設定')

@section('content')
<div class="container">
    <div class="row">
        <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <h1 class="text-center"><a class="text-dark" href="/">memo</a></h1>
            <div class="card mt-3">
                <div class="card-body text-center">
                    <h2 class="h3 card-title text-center mt-2">パスワード再設定</h2>
                    @include('error_card_list')

                    <form method="POST" action="{{ route('password_reset.email.send') }}">
                        @csrf
                        <div class="md-form">
                            <label for="email">メールアドレス</label>
                            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control">
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-block blue-gradient mt-2 mb-2">メールを送信</button>
                    </form>
                </div>
                <a href="{{ route('admin.login') }}" class="card-text mb-2 ml-3">戻る</a>
            </div>
        </div>
    </div>
@endsection


{{-- @if (session('status'))
<div class="card-text alert alert-success">
    {{ session('status') }}
</div>
@endif --}}