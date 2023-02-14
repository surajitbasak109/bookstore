<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublisherController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('publishers.index');
    }

    public function datatables()
    {
        $query = Publisher::orderBy('created_at', 'desc')->get();

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

        $publisher = Publisher::create($request->only(['name']));

        return response()->json([
            'message' => 'Publisher created',
            'publisher' => $publisher
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
        $publisher = Publisher::findOrFail($id);

        return response()->json($publisher->only(['id', 'name']));
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

        $publisher = Publisher::findOrFail($id);
        $publisher->name = $request->name;
        $publisher->save();

        return response()->json([
            'message' => 'Publisher updated',
            'publisher' => $publisher
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
        $publisher = Publisher::findOrFail($id);

        $publisher->delete();

        return response()->json(['message' => 'Publisher deleted']);
    }
}
