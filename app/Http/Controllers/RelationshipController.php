<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use Illuminate\Http\Request;
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
        $relationships = \App\Models\Relationship::paginate(100);

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
        flash('Relationships cannot be directly created as they are managed via contacts')->error();

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
        flash('Relationships cannot be directly stored as they are managed via contacts')->error();

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
        $relationship = \App\Models\Relationship::findOrFail($id);

        return view('relationships.show', compact('relationship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   // TODO: stub: re-evaluate handling of relationships to refactor person controller to avoid repetition
        $this->authorize('update-relationship');
        flash('Relationships cannot be directly edited as they are managed via contacts')->error();

        return Redirect::action('RelationshipController@show', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   // TODO: stub: re-evaluate handling of relationships to refactor person controller to avoid repetition
        $this->authorize('update-relationship');
        flash('Relationships cannot be directly updated as they are managed via contacts')->error();

        return Redirect::action('RelationshipController@show', $id);
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

        \App\Models\Relationship::destroy($id);

        flash('Relationship ID#: '.$id.' deleted')->warning()->important();

        return redirect()->back();
    }
}
