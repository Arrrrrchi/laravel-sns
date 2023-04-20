@extends('app')

@section('title', '記事一覧')

@section('content')
    @include('nav')

    @if(session('message'))
    <div class="card mt-3">
    <div class="card-body p-2 text-center orange text-white">
        {{ session('message') }}
    </div>
    </div>
    @endif

    <div class="container">
        @foreach($articles as $article)
            @include('articles.card')
        @endforeach
    </div>
@endsection
