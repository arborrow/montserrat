<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class RelationshipTypesController extends Controller
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
        // TODO: figure out how to get parish information
        $relationship_types = \montserrat\RelationshipType::whereIsActive(1)->orderBy('description')->get();
        return view('relationships.types.index',compact('relationship_types'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $contact_types = \montserrat\ContactType::OrderBy('name')->pluck('name','name');
        return view('relationships.types.create', compact('contact_types')); 
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'name_a_b' => 'required',
            'label_a_b' => 'required',
            'name_b_a' => 'required',
            'label_b_a' => 'required',
            'contact_type_a' => 'required',
            'contact_type_b' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1'
        ]);
        
        $relationship_type = new \montserrat\RelationshipType;
        $relationship_type->description = $request->input('description');
        $relationship_type->name_a_b = $request->input('name_a_b');
        $relationship_type->label_a_b = $request->input('label_a_b');
        
        $contact_type_a = \montserrat\ContactType::whereName($request->input('contact_type_a'))->firstOrFail();
        $contact_type_b = \montserrat\ContactType::whereName($request->input('contact_type_b'))->firstOrFail();
        
        if ($contact_type_a->is_reserved>0)
        {   // Explanation: primary type of Individual, Organization, or Household
            $relationship_type->contact_type_a = $contact_type_a->name;
        } else {
            // WARNING: assumes that if it is not a primary contact type then it is an organization (this may not always be true in the future, but for now ...
            $relationship_type->contact_type_a = 'Organization';
            $relationship_type->contact_sub_type_a = $contact_type_a->name;
        }
        
        if ($contact_type_b->is_reserved>0)
        {   // Explanation: primary type of Individual, Organization, or Household
            $relationship_type->contact_type_b = $contact_type_b->name;
        } else {
            // WARNING: assumes that if it is not a primary contact type then it is an organization (this may not always be true in the future, but for now ...
            $relationship_type->contact_type_b = 'Organization';
            $relationship_type->contact_sub_type_b = $contact_type_b->name;
        }
        
        $relationship_type->name_b_a = $request->input('name_b_a');
        $relationship_type->label_b_a = $request->input('label_b_a');
        $relationship_type->contact_type_b = $request->input('contact_type_b');
        
        $relationship_type->is_active = $request->input('is_active');
        $relationship_type->is_reserved = $request->input('is_reserved');
       
        $relationship_type->save();
       
        return Redirect::action('RelationshipTypesController@index');//

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       $relationship_type = \montserrat\RelationshipType::findOrFail($id);
       
       return view('relationships.types.show',compact('relationship_type'));//
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $relationship_type = \montserrat\RelationshipType::find($id);
        //dd($relationship_type);
        return view('relationships.types.edit',compact('relationship_type'));
    
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
        $this->validate($request, [
            'description' => 'required',
            'name_a_b' => 'required',
            'label_a_b' => 'required',
            'name_b_a' => 'required',
            'label_b_a' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1'
        ]);
        
        $relationship_type = \montserrat\RelationshipType::findOrFail($request->input('id'));
        $relationship_type->description = $request->input('description');
        $relationship_type->name_a_b = $request->input('name_a_b');
        $relationship_type->label_a_b = $request->input('label_a_b');
        $relationship_type->name_b_a = $request->input('name_b_a');
        $relationship_type->label_b_a = $request->input('label_b_a');
        $relationship_type->is_active = $request->input('is_active');
        $relationship_type->is_reserved = $request->input('is_reserved');
       
        $relationship_type->save();
    
        return Redirect::action('RelationshipTypesController@index');//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \montserrat\RelationshipType::destroy($id);
        return Redirect::action('RelationshipTypesController@index');
    
    }
    
}


