@extends('app')

@section('title', $user->name. 'のフォロワー')

@section('content')
    @include('nav')
    <div class="container">
        @include('user.profile')
        @include('user.tabs', ['hasArticles' => false, 'hasLikes' => false])
        @foreach($followers as $person)
            @include('user.person')
        @endforeach
    </div>
@endsection
