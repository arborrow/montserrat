<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;


class PersonsController extends Controller
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
        //
        $persons = \montserrat\Person::with('parish')->orderBy('lastname', 'asc', 'firstname','asc')->Paginate(25);
        return view('persons.index',compact('persons'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('persons.create'); 
    
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
        
        $person = new \montserrat\Person;
        $person->title = $request->input('title');
        $person->firstname = $request->input('firstname');
        $person->middlename = $request->input('middlename');
        $person->lastname = $request->input('lastname');
        $person->suffix = $request->input('suffix');
        $person->nickname = $request->input('nickname');
        $person->address1 = $request->input('address1');
        $person->address2 = $request->input('address2');
        $person->city = $request->input('city');
        $person->state = $request->input('state');
        $person->zip = $request->input('zip');
        $person->country = $request->input('country');
        $person->homephone = $request->input('homephone');
        $person->workphone = $request->input('workphone');
        $person->mobilephone = $request->input('mobilephone');
        $person->faxphone = $request->input('faxphone');
        $person->emergencycontactname = $request->input('emergencycontactname');
        $person->emergencycontactphone = $request->input('emergencycontactphone');
        $person->emergencycontactphone2 = $request->input('emergencycontactphone2');
        $person->url = $request->input('url');
        $person->email = $request->input('email');
        $person->gender = $request->input('gender');
        $person->ethnicity = $request->input('ethnicity');
        $person->parish_id = $request->input('parish_id');
        $person->languages = $request->input('languages');
        $person->medical = $request->input('medical');
        $person->dietary = $request->input('dietary');
        $person->notes = $request->input('notes');
        $person->roompreference = $request->input('roompreference');
        $person->is_donor = $request->input('is_donor');
        $person->is_retreatant = $request->input('is_retreatant');
        $person->is_director = $request->input('is_director');
        $person->is_innkeeper = $request->input('is_innkeeper');
        $person->is_assistant = $request->input('is_assistant');
        $person->is_captain = $request->input('is_captain');
        $person->is_staff = $request->input('is_staff');
        $person->is_volunteer = $request->input('is_volunteer');
        $person->is_pastor = $request->input('is_pastor');
        $person->is_bishop = $request->input('is_bishop');
        $person->is_catholic = $request->input('is_catholic');
        $person->is_board = $request->input('is_board');
        
        $person->save();
        return Redirect::action('PersonsController@index');//

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
       $person = \montserrat\Person::find($id);
        
       return view('persons.show',compact('person'));//
    
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
        $person = \montserrat\Person::find($id);
      
        return view('persons.edit',compact('person'));
    
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
        //
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other'
        ]);
        $person = \montserrat\Person::findOrFail($request->input('id'));
        $person->title = $request->input('title');
        $person->firstname = $request->input('firstname');
        $person->middlename = $request->input('middlename');
        $person->lastname = $request->input('lastname');
        $person->suffix = $request->input('suffix');
        $person->nickname = $request->input('nickname');
        $person->address1 = $request->input('address1');
        $person->address2 = $request->input('address2');
        $person->city = $request->input('city');
        $person->state = $request->input('state');
        $person->zip = $request->input('zip');
        $person->country = $request->input('country');
        $person->homephone = $request->input('homephone');
        $person->workphone = $request->input('workphone');
        $person->mobilephone = $request->input('mobilephone');
        $person->faxphone = $request->input('faxphone');
        $person->emergencycontactname = $request->input('emergencycontactname');
        $person->emergencycontactphone = $request->input('emergencycontactphone');
        $person->emergencycontactphone2 = $request->input('emergencycontactphone2');
        $person->url = $request->input('url');
        $person->email = $request->input('email');
        $person->gender = $request->input('gender');
        $person->ethnicity = $request->input('ethnicity');
        $person->parish_id = $request->input('parish_id');
        $person->languages = $request->input('languages');
        $person->medical = $request->input('medical');
        $person->dietary = $request->input('dietary');
        $person->notes = $request->input('notes');
        $person->roompreference = $request->input('roompreference');
        $person->is_donor = $request->input('is_donor');
        $person->is_retreatant = $request->input('is_retreatant');
        $person->is_director = $request->input('is_director');
        $person->is_innkeeper = $request->input('is_innkeeper');
        $person->is_assistant = $request->input('is_assistant');
        $person->is_captain = $request->input('is_captain');
        $person->is_staff = $request->input('is_staff');
        $person->is_volunteer = $request->input('is_volunteer');
        $person->is_pastor = $request->input('is_pastor');
        $person->is_bishop = $request->input('is_bishop');
        $person->is_catholic = $request->input('is_catholic');
        $person->is_board = $request->input('is_board');
        
        $person->save();
        return Redirect::action('PersonsController@index');//
        

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
        \montserrat\Person::destroy($id);
        return Redirect::action('PersonsController@index');
    
    }
    public function assistants()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_assistant','1')->get();
        //dd($persons);
        return view('persons.assistants',compact('persons'));   //
    
    }
    public function bishops()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_bishop','1')->get();
        //dd($persons);
        return view('persons.bishops',compact('persons'));   //
    
    }

    public function boardmembers()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_board','1')->get();
        //dd($persons);
        return view('persons.boardmembers',compact('persons'));   //
    
    }
    public function captains()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_captain','1')->get();
        //dd($persons);
        return view('persons.captains',compact('persons'));   //
    
    }
    public function directors()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_director','1')->get();
        //dd($persons);
        return view('persons.directors',compact('persons'));   //
    
    }
    public function donors()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_donor','1')->get();
        //dd($persons);
        return view('persons.donors',compact('persons'));   //
    
    }
    public function employees()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_staff','1')->get();
        //dd($persons);
        return view('persons.employees',compact('persons'));   //
    
    }
    public function innkeepers()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_innkeeper','1')->get();
        //dd($persons);
        return view('persons.innkeepers',compact('persons'));   //
    
    }
    public function pastors()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_pastor','1')->get();
        //dd($persons);
        return view('persons.pastors',compact('persons'));   //
    
    }
    public function retreatants()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_retreatant','1')->get();
        //dd($persons);
        return view('persons.retreatants',compact('persons'));   //
    
    }
    public function volunteers()
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where('is_volunteer','1')->get();
        //dd($persons);
        return view('persons.volunteers',compact('persons'));   //
    
    }
    
}
