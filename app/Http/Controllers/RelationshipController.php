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
        ->select('r.id','r.contact_id_a as husband_id', 'h.sort_name as husband_name', 'r.contact_id_b as wife_id', 'w.sort_name as wife_name','ha.street_address as husband_address','ha.city as husband_city','ha.postal_code as husband_zip','wa.street_address as wife_address','wa.city as wife_city','wa.postal_code as wife_zip')
        ->leftJoin('contact as h','r.contact_id_a','=','h.id')
        ->leftJoin('contact as w','r.contact_id_b','=','w.id')
        ->leftJoin('address as ha','r.contact_id_a','=','ha.contact_id')
        ->leftJoin('address as wa','r.contact_id_b','=','wa.contact_id')
        ->where('r.relationship_type_id','=',2)
        ->where('ha.is_primary','=',1)
        ->where('wa.is_primary','=',1)
        ->whereNull('r.deleted_at')
        ->whereRaw('ha.street_address <> wa.street_address')
        ->orderBy('husband_name')
        ->get();
      return view('relationships.disjoined', compact('couples'));
    }
    public function rejoin($id,$dominant) {
      $this->authorize('update-relationship');
      $this->authorize('update-contact');
      $relationship = \App\Relationship::with('contact_a.address_primary','contact_b.address_primary')->findOrFail($id);
      switch ($dominant) {
        case $relationship->contact_id_a :
          $relationship->contact_b->address_primary->street_address = $relationship->contact_a->address_primary->street_address;
          $relationship->contact_b->address_primary->city = $relationship->contact_a->address_primary->city;
          $relationship->contact_b->address_primary->state_province_id = $relationship->contact_a->address_primary->state_province_id;
          $relationship->contact_b->address_primary->postal_code = $relationship->contact_a->address_primary->postal_code;
          $relationship->contact_b->address_primary->save();
        break;
        case $relationship->contact_id_b :
          $relationship->contact_a->address_primary->street_address = $relationship->contact_b->address_primary->street_address;
          $relationship->contact_a->address_primary->city = $relationship->contact_b->address_primary->city;
          $relationship->contact_a->address_primary->state_province_id = $relationship->contact_b->address_primary->state_province_id;
          $relationship->contact_a->address_primary->postal_code = $relationship->contact_b->address_primary->postal_code;
          $relationship->contact_a->address_primary->save();
        break;
        default : // do not do anything as there is a relationship mismatch error
      }
      return Redirect::back();
    }
}
