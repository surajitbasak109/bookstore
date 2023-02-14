@extends('layouts.guest')
@section('title', 'Welcome to Our Bookstore')

@section('content')
<div id="recent-books" class="my-5">
    <h1 class="text-center mb-5">@yield('title')</h1>
    <div class="container">
        <h2>Recently published books</h2>
        <div class="row">
            @foreach ($recentBooks as $book)
            <div class="col-md-4 col-sm-6 mb-5">
                <div class="card h-100 shadow">
                    <div class="book-img">
                        <img src="{{ $book->image_url }}" class="shadow" alt="book cover">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ $book->short_description }}</p>
                        <div class="book-type">
                            <div class="genre">{{ $book->genre_name }}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="book-info">
                            <span>{{ $book->author_name }}</span>
                            <span>{{ \Carbon\Carbon::parse($book->published)->format('M Y') }}</span>
                            <span>{{ $book->publisher_name }}</span>
                        </div>
                        <a href="{{ route('guest.book-detail', [$book->id]) }}" class="btn btn-primary btn-block">Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="user-reviews" class="py-5">
    <div class="container">
        <h2 class="text-center text-light mb-5">Bookstore User Reviews</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote bg-light">
                            <p class="text-dark">"I love browsing through books in this online store. It easy to navigate and find exactly what I'm looking for and I am trusting this store."</p>
                            <footer class="blockquote-footer">Saint Augustine</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote bg-light">
                            <p class="text-dark">"The user-friendly interface and clean layout of this bookstore make it a pleasure to shop for books. It is sleek and modern."</p>
                            <footer class="blockquote-footer">Ava Smith</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote bg-light">
                            <p class="text-dark">"I was looking for a new way to discover books and this bookstore exceeded my expectations. It makes it easy to browse through books."</p>
                            <footer class="blockquote-footer">Ethan Davis</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote bg-light">
                            <p class="text-dark">"As an avid reader, I was impressed by the selection of books available in this online store. It is easy to find what I need and order with just a few clicks."</p>
                            <footer class="blockquote-footer">Olivia Johnson</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote bg-light">
                            <p class="text-dark">"I appreciate the attention to detail in the design of this bookstore. It is not only stylish but also functional, making it easy to find and purchase books."</p>
                            <footer class="blockquote-footer">Noah Brown</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="slideshow-wrap" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="quote-slideshow" class="carousel slide" data-bs-ride="carousel">
                    <!--Slides-->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <blockquote class="blockquote">
                                <p class="mb-3">"A book is a dream that you hold in your hand."</p>
                                <footer class="blockquote-footer">Neil Gaiman</footer>
                            </blockquote>
                        </div>
                        <div class="carousel-item">
                            <blockquote class="blockquote">
                                <p class="mb-3">"The more that you read, the more things you will know. The more that you learn, the more places you'll go."</p>
                                <footer class="blockquote-footer">Dr. Seuss</footer>
                            </blockquote>
                        </div>
                        <div class="carousel-item">
                            <blockquote class="blockquote">
                                <p class="mb-3">"Books are the quietest and most constant of friends; they are the most accessible and wisest of counselors, and the most patient of teachers."</p>
                                <footer class="blockquote-footer">Charles W. Eliot</footer>
                            </blockquote>
                        </div>
                    </div>

                    <!--Controls-->
                    <button type="button" class="carousel-control-prev" data-bs-target="#quote-slideshow" role="button" data-bs-slide="prev">
                        <i class="fa fa-angle-left fa-4x text-secondary" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button type="button" class="carousel-control-next" data-bs-target="#quote-slideshow" role="button" data-bs-slide="next">
                        <i class="fa fa-angle-right fa-4x text-secondary" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
