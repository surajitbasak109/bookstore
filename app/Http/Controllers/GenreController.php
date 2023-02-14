<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('genres.index');
    }

    public function datatables()
    {
        $query = Genre::orderBy('created_at', 'desc')->get();

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
            'name' => ['required', 'unique:genres,name']
        ]);

        $genre = Genre::create($request->only(['name']));

        return response()->json([
            'message' => 'Genre created',
            'genre' => $genre
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
        $genre = Genre::findOrFail($id);

        return response()->json($genre->only(['id', 'name']));
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
            'name' => ['required', Rule::unique('genres', 'name')->ignore($id)]
        ]);

        $genre = Genre::findOrFail($id);
        $genre->name = $request->name;
        $genre->save();

        return response()->json([
            'message' => 'Genre updated',
            'genre' => $genre
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
        $genre = Genre::findOrFail($id);

        $genre->delete();

        return response()->json(['message' => 'Genre deleted']);
    }
}
