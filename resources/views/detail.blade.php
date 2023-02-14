@extends('layouts.guest')
@section('title', $book->title)

@section('content')
<div id="book-detail">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $book->image_url }}" class="img-fluid" alt="Book Cover">
            </div>
            <div class="col-md-8">
                <h1 class="text-primary">{{ $book->title }}</h1>
                <h5 class="text-secondary">by {{ $book->author_name }}</h5>
                <hr class="my-4">
                <p><strong>Genre:</strong> {{ $book->genre_name }}</p>
                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                <p><strong>Publisher:</strong> {{ $book->publisher_name }}</p>
                <p><strong>Published:</strong> {{ $book->published_human }}</p>
                <hr class="my-4">
                <p>{{ $book->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
