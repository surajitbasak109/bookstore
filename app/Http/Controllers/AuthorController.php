<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('authors.index');
    }

    public function datatables()
    {
        $query = Author::orderBy('created_at', 'desc')->get();

        return $this->getDataTables($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:authors,name']
        ]);

        $author = Author::create($request->only(['name']));

        return response()->json([
            'message' => 'Author createed',
            'publisher' => $author
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);

        return response()->json($author->only(['id', 'name']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', Rule::unique('authors', 'name')->ignore($id)]
        ]);

        $author = Author::findOrFail($id);
        $author->name = $request->name;
        $author->save();

        return response()->json([
            'message' => 'Author updated',
            'author' => $author
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        $author->delete();

        return response()->json(['message' => 'Author deleted']);
    }
}
