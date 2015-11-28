<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class RetreatantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $retreatants = \App\Retreatant::orderBy('lastname', 'asc','firstname', 'asc')->get();
          
        return view('retreatants.index',compact('retreatants'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('retreatants.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other'
        ]);
        
        $retreatant = new \App\Retreatant;
        $retreatant->title = $request->input('title');
        $retreatant->firstname = $request->input('firstname');
        $retreatant->middlename = $request->input('middlename');
        $retreatant->lastname = $request->input('lastname');
        $retreatant->suffix = $request->input('suffix');
        $retreatant->nickname = $request->input('nickname');
        $retreatant->address1 = $request->input('address1');
        $retreatant->address2 = $request->input('address2');
        $retreatant->city = $request->input('city');
        $retreatant->state = $request->input('state');
        $retreatant->zip = $request->input('zip');
        $retreatant->country = $request->input('country');
        $retreatant->homephone = $request->input('homephone');
        $retreatant->workphone = $request->input('workphone');
        $retreatant->mobilephone = $request->input('mobilephone');
        $retreatant->faxphone = $request->input('faxphone');
        $retreatant->emergencycontactname = $request->input('emergencycontactname');
        $retreatant->emergencycontactphone = $request->input('emergencycontactphone');
        $retreatant->emergencycontactphone2 = $request->input('emergencycontactphone2');
        $retreatant->url = $request->input('url');
        $retreatant->email = $request->input('email');
        $retreatant->gender = $request->input('gender');
        $retreatant->ethnicity = $request->input('ethnicity');
        $retreatant->parish_id = $request->input('parish_id');
        $retreatant->languages = $request->input('languages');
        $retreatant->medical = $request->input('medical');
        $retreatant->dietary = $request->input('dietary');
        $retreatant->notes = $request->input('notes');
        $retreatant->roompreference = $request->input('roompreference');
        
        $retreatant->save();
        return Redirect::action('RetreatantsController@index');//
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
          $retreatant = \App\Retreatant::find($id);
        
       return view('retreatants.show',compact('retreatant'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $retreatant = \App\Retreatant::find($id);
      
       return view('retreatants.edit',compact('retreatant'));
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other'
        ]);
        $retreatant = \App\Retreatant::findOrFail($request->input('id'));
        $retreatant->title = $request->input('title');
        $retreatant->firstname = $request->input('firstname');
        $retreatant->middlename = $request->input('middlename');
        $retreatant->lastname = $request->input('lastname');
        $retreatant->suffix = $request->input('suffix');
        $retreatant->nickname = $request->input('nickname');
        $retreatant->address1 = $request->input('address1');
        $retreatant->address2 = $request->input('address2');
        $retreatant->city = $request->input('city');
        $retreatant->state = $request->input('state');
        $retreatant->zip = $request->input('zip');
        $retreatant->country = $request->input('country');
        $retreatant->homephone = $request->input('homephone');
        $retreatant->workphone = $request->input('workphone');
        $retreatant->mobilephone = $request->input('mobilephone');
        $retreatant->faxphone = $request->input('faxphone');
        $retreatant->emergencycontactname = $request->input('emergencycontactname');
        $retreatant->emergencycontactphone = $request->input('emergencycontactphone');
        $retreatant->emergencycontactphone2 = $request->input('emergencycontactphone2');
        $retreatant->url = $request->input('url');
        $retreatant->email = $request->input('email');
        $retreatant->gender = $request->input('gender');
        $retreatant->ethnicity = $request->input('ethnicity');
        $retreatant->parish_id = $request->input('parish_id');
        $retreatant->languages = $request->input('languages');
        $retreatant->medical = $request->input('medical');
        $retreatant->dietary = $request->input('dietary');
        $retreatant->notes = $request->input('notes');
        $retreatant->roompreference = $request->input('roompreference');
        
        $retreatant->save();
        return Redirect::action('RetreatantsController@index');//
        
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
        \App\Retreatant::destroy($id);
       return Redirect::action('RetreatantsController@index');
    }
}
