<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use JeroenG\Explorer\Domain\Syntax\Terms;

class GuestController extends Controller
{
    public function index()
    {
        $recentBooks = Book::orderBy('published', 'desc')->take(10)->get();
        $showSearchForm = true;
        $showFooter = true;
        return view('landing', compact('recentBooks', 'showSearchForm', 'showFooter'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $showSearchForm = true;
        $showFooter = true;

        $authors = Author::distinct()->select(['name', 'id'])->get();
        $genres = Genre::distinct()->select(['name', 'id'])->get();
        $publishers = Publisher::distinct()->select(['name', 'id'])->get();
        $isbns = Book::select('isbn')->without(['author', 'genre', 'publisher'])->distinct()->get();

        return view('search', compact(
            'query',
            'showSearchForm',
            'showFooter',
            'authors',
            'genres',
            'publishers',
            'isbns',
        ));
    }

    public function searchAjax(Request $request)
    {
        $query = Book::search($request->get('query'));

        // $request->dd();

        if ($request->has('author')) {
            $query->must(new Terms('author_id', [$request->get('author')]));
            // $query->where('author_id', $request->get('author'));
        }

        if ($request->has('genre')) {
            $query->must(new Terms('genre_id', [$request->get('genre')]));
        }

        if ($request->has('publisher')) {
            $query->must(new Terms('publisher_id', [$request->get('publisher')]));
        }

        if ($request->has('isbn')) {
            $query->must(new Terms('isbn', [$request->get('isbn')]));
        }

        $books = $query->paginate(12);

        return response()->json($books);
    }

    public function searchTitle(Request $request)
    {
        $keyword = $request->get('query');

        $query = Book::search($keyword)
            ->field('id')
            ->field('title');

        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        $suggestions = $query->get();

        return response()->json($suggestions);
    }

    public function bookDetail(Book $book, Request $request)
    {
        $showSearchForm = true;
        $showFooter = true;
        return view('detail', compact('book', 'showSearchForm', 'showFooter'));
    }
}
