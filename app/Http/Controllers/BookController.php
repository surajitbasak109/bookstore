<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('books.index');
    }

    public function datatables()
    {
        $query = Book::orderBy('created_at', 'desc')->get();

        return $this->getDataTables($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::select(['id', 'name AS text'])->get();
        $genres = Genre::select(['id', 'name AS text'])->get();
        $publishers = Publisher::select(['id', 'name AS text'])->get();
        return view('books.create', compact('authors', 'genres', 'publishers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $imageFileName = null;
        if ($request->has('image')) {
            $ext = $request->image->extension();
            $imageFileName = time() . '.' . $ext;
            $request->image->storeAs('public/images', $imageFileName);
        }

        $newBook = array_merge($request->only([
            'title',
            'isbn',
            'author_id',
            'genre_id',
            'publisher_id',
            'description'
        ]), [
            'image' => '/images/' . $imageFileName,
        ]);

        $book = Book::create($newBook);

        return response()->json([
            'message' => 'Book created',
            'book' => $book
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::select(['id', 'name AS text'])->get();
        $genres = Genre::select(['id', 'name AS text'])->get();
        $publishers = Publisher::select(['id', 'name AS text'])->get();
        return view('books.edit', compact('book', 'authors', 'genres', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->title = $request->input('title');
        $book->isbn = $request->input('isbn');
        $book->author_id = $request->input('author_id');
        $book->genre_id = $request->input('genre_id');
        $book->publisher_id = $request->input('publisher_id');
        $book->published = $request->input('published');
        $book->description = $request->input('description');

        if ($request->has('image')) {
            $ext = $request->image->extension();
            $imageFileName = time() . '.' . $ext;
            $request->image->storeAs('public/images', $imageFileName);

            $book->image = $imageFileName;
        }

        $book->save();

        return response()->json([
            'message' => 'Book updated',
            'book' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if (!is_null($book->image) && strpos($book->image, 'http') === false) {
            Storage::delete($book->image);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }
}
