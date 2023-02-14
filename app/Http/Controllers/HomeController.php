<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $booksCount = Book::count();
        $authorsCount = Author::count();
        $genresCount = Genre::count();
        $publishersCount = Publisher::count();

        return view('home', compact(
            'booksCount',
            'authorsCount',
            'genresCount',
            'publishersCount',
        ));
    }
}
