<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Relationship;
use Illuminate\Support\Facades\Redirect;
use DB;


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
    {
        $this->authorize('create-relationship');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-relationship');
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
        $this->authorize('update-relationship');
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
        return Redirect::back();
    }
    public function disjoined() {
      $this->authorize('update-relationship');
      $this->authorize('update-contact');
      $couples = DB::table('relationship as r')
        ->select('r.id','r.contact_id_a as husband_id','r.contact_id_b as wife_id','ha.street_address as husband_address','wa.street_address as wife_address')
        ->leftJoin('address as ha','r.contact_id_a','=','ha.contact_id')
        ->leftJoin('address as wa','r.contact_id_b','=','wa.contact_id')
        ->where('r.relationship_type_id','=',2)
        ->where('ha.is_primary','=',1)
        ->where('wa.is_primary','=',1)
        ->whereRaw('ha.street_address <> wa.street_address')
        ->get();
      return view('relationships.disjoined', compact('couples'));
    }
}
