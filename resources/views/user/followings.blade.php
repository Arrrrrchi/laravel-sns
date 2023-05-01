@extends('app')

@section('title', $user->name . 'のフォロー中')

@section('content')
    @include('nav')
    <div class="container">
        @include('user.profile')
        @include('user.tabs', ['hasArticles' => false, 'hasLikes' => false])
        @foreach($followings as $person)
            @include('user.person')
        @endforeach
    </div>
@endsection
