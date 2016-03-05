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
        $persons = \montserrat\Person::with('parish')->orderBy('lastname', 'asc', 'firstname','asc')->Paginate(100);
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
        //$parishes= \montserrat\Parish::with('diocese')->orderby('name')->lists('name','id');
        //$parishes = \montserrat\Parish::join('dioceses', 'parishes.diocese_id', '=', 'dioceses.id')->select('parishes.name', 'parishes.id')->lists('parishes.name','parishes.id');
      
        $parishes = \montserrat\Parish::select(\DB::raw('CONCAT(parishes.name," (",parishes.city,"-",dioceses.name,")") as parishname'), 'parishes.id')->join('dioceses','parishes.diocese_id','=','dioceses.id')->orderBy('parishname')->lists('parishname','parishes.id');
        $parishes->prepend('N/A',0);  
        $ethnicities = \montserrat\Ethnicity::orderby('ethnicity')->lists('ethnicity','ethnicity');
        return view('persons.create',compact('parishes','ethnicities')); 
    
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
            'dob' => 'date',            
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other,Unspecified'
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
        if (!empty($request->input('email'))) {
            $person->email = $request->input('email');
        } else {
            $person->email = NULL;
        }
        $person->gender = $request->input('gender');
        $person->dob = $request->input('dob');
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
        $person->is_formerboard = $request->input('is_formerboard');
        $person->is_jesuit = $request->input('is_jesuit');
        $person->is_deceased = $request->input('is_deceased');
        
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
       $person = \montserrat\Person::with('touchpoints','touchpoints.staff','websites','addresses','addresses.location','addresses.state','addresses.country','emails','emails.location','phones','phones.location')->findOrFail($id);
       
       //dd($person);
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
        $parishes = \montserrat\Parish::select(\DB::raw('CONCAT(parishes.name," (",parishes.city,"-",dioceses.name,")") as parishname'), 'parishes.id')->join('dioceses','parishes.diocese_id','=','dioceses.id')->orderBy('parishname')->lists('parishname','parishes.id');
        $parishes->prepend('N/A',0);  
        $ethnicities = \montserrat\Ethnicity::orderby('ethnicity')->lists('ethnicity','ethnicity');

//dd($parishes);
        return view('persons.edit',compact('person','parishes','ethnicities'));
    
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
            'dob' => 'date',
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other,Unspecified'
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
        if (empty($person->email)) {
            $person->email = NULL;
        } else {
            $person->email = $request->input('email');
        }
        $person->gender = $request->input('gender');
        $person->dob = $request->input('dob');
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
        $person->is_formerboard = $request->input('is_formerboard');
        $person->is_jesuit = $request->input('is_jesuit');
        $person->is_deceased = $request->input('is_deceased');
        
        
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
        $role['name'] = 'Assistants';
        $role['field'] = 'is_assistant';
        return $this->role($role);
    }
    public function bishops()
    {
        //
        $role['name'] = 'Bishops';
        $role['field'] = 'is_bishop';
        return $this->role($role);
    
    }

    public function boardmembers()
    {
        //
        $role['name'] = 'Board members';
        $role['field'] = 'is_board';
        return $this->role($role);
        
    }
    public function captains()
    {
        //
        $role['name'] = 'Captains';
        $role['field'] = 'is_captain';
        return $this->role($role);
    
    }
    public function catholics()
    {
        $role['name'] = 'Catholics';
        $role['field'] = 'is_catholic';
        return $this->role($role);
    }
    public function deceased()
    {
        //
        $role['name'] = 'Deceased';
        $role['field'] = 'is_deceased';
        return $this->role($role);
    
    }

    public function directors()
    {
        //
        $role['name'] = 'Retreat Directors';
        $role['field'] = 'is_director';
        return $this->role($role);
        
    }
    public function donors()
    {
        //
        $role['name'] = 'Donors';
        $role['field'] = 'is_donor';
        return $this->role($role);
    
    }
    public function employees()
    {
        $role['name'] = 'Employees';
        $role['field'] = 'is_staff';
        return $this->role($role);
    }
    public function formerboard()
    {
        //
        $role['name'] = 'Former Board Members';
        $role['field'] = 'is_formerboard';
        return $this->role($role);
    
    }
   public function innkeepers()
    {
        //
        $role['name'] = 'Retreat Innkeepers';
        $role['field'] = 'is_innkeeper';
        return $this->role($role);
    
    }
    public function jesuits()
    {
        //
        $role['name'] = 'Jesuits';
        $role['field'] = 'is_jesuit';
        return $this->role($role);
    
    }
  public function pastors()
    {
        //
        $role['name'] = 'Pastors';
        $role['field'] = 'is_pastor';
        return $this->role($role);

    }
    public function retreatants()
    {
        //
        $role['name'] = 'Retreatants';
        $role['field'] = 'is_retreatant';
        return $this->role($role);
    }
    
    public function volunteers()
    {
        //
        $role['name'] = 'Volunteers';
        $role['field'] = 'is_volunteer';
        return $this->role($role);
    }
    
    public function role($role)
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where($role['field'],'1')->get();
        //dd($persons);
        return view('persons.role',compact('persons','role'));   //
    
    }
    
    
}
