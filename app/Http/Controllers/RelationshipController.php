<?php

namespace App\Http\Controllers;

use App\Relationship;
use App\RelationshipType;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateRelationshipRequest;
use Illuminate\Support\Facades\Redirect;

class RelationshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-relationship');
        $relationships = \App\Relationship::paginate(100);

        return view('relationships.index', compact('relationships'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   // TODO: stub: re-evaluate handling of relationships to refactor person controller to avoid repetition
        $this->authorize('create-relationship');

        return Redirect::action('RelationshipController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   // relationships are not created directly here; they are created through the person controller
        // TODO: stub: re-evaluate handling of relationships to refactor person controller to avoid repetition
        $this->authorize('create-relationship');

        return Redirect::action('RelationshipController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-relationship');
        $relationship = \App\Relationship::findOrFail($id);

        return view('relationships.show', compact('relationship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-relationship');
        $relationship = \App\Relationship::findOrFail($id);
        $relationship_types =  \App\RelationshipType::orderby('description')->pluck('description', 'id');

        return view('relationships.edit', compact('relationship','relationship_types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRelationshipRequest $request, $id)
    {
        $this->authorize('update-relationship');

        $relationship = \App\Relationship::findOrFail($request->input('id'));
        $relationship->relationship_type_id = $request->input('relationship_type_id');
        $relationship->description = $request->input('description');
        $relationship->start_date = $request->input('start_date');
        $relationship->end_date = $request->input('end_date');
        $relationship->is_active = $request->input('is_active');
        $relationship->save();

        return Redirect::action('RelationshipController@show', $relationship->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-relationship');
        \App\Relationship::destroy($id);

        return redirect()->back();
    }
}
