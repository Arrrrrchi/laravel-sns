@extends('app')

@section('title', $user->name)

@section('content')
    @include('nav')
    <div class="container">
        @include('user.profile')
        <ul class="nav nav-tabs nav-justified mt-3">
            <li class="nav-item">
            <a class="nav-link text-muted active"
                href="{{ route('user.show', ['name' => $user->name]) }}">
                記事
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-muted"
                href="{{ route('user.likes', ['name' => $user->name]) }}">
                いいね
            </a>
            </li>
        </ul>
        @foreach($articles as $article)
            @include('articles.card')
        @endforeach
    </div>
@endsection
