<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class RegistrationsController extends Controller
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
        $registrations = \montserrat\Registration::whereDate('end', '>=', date('Y-m-d'))->orderBy('start','asc')->get();
        foreach ($registrations as $registration) {
            //dd($registration->retreat_id);
            $retreat = \montserrat\Retreat::findOrFail($registration->retreat_id);
            //dd($retreat);
            $retreatant = \montserrat\Person::findOrFail($registration->retreatant_id);
            //dd($retreatant);
            if (empty($retreat)) {
                $registration->retreat = 'Not assigned';
            } else {
                $registration->retreat = $retreat;
            }
            if (empty($retreatant)) {
                $registration->retreatant = 'Not assigned';
            } else {
                $registration->retreatant = $retreatant;
            }
       //dd($registration->retreatant);
           
            
        }
        //dd($registrations);
        return view('registrations.index',compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->lists('idnumber','title','id');
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start,"%m-%d-%Y"),")") as description'), 'id')->where("end",">",\Carbon\Carbon::today())->orderBy('start')->lists('description','id');
        $retreatants = \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_retreatant','=','1')->orderBy('fullname')->lists('fullname','id');

        return view('registrations.create',compact('retreats','retreatants')); 
        //dd($retreatants);
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
        'register' => 'required|date',
        'confirmattend' => 'date',
        'confirmregister' => 'date',
        'retreat_id' => 'required|integer|min:0',
        'retreatant_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:1000',
        ]);

    $retreat = \montserrat\Retreat::findOrFail($request->input('retreat_id'));

    $registration = new \montserrat\Registration;
    $registration->retreat_id= $request->input('retreat_id');
    $registration->start = $retreat->start;
    $registration->end = $retreat->end;
    $registration->retreatant_id= $request->input('retreatant_id');
    $registration->register = $request->input('register');
    //dd($request->confirmattend);
    $registration->confirmattend = $request->input('confirmattend');
    
    $registration->confirmregister = $request->input('confirmregister');
    $registration->confirmedby = $request->input('confirmedby');
    $registration->deposit = $request->input('deposit');
    $registration->notes = $request->input('notes');
    
    $registration->save();
    $registrations = \montserrat\Registration::where('retreat_id','=',$request->input('retreat_id'))->count();
    $retreat->attending = $registrations;
    $retreat->save();
    //dd($registrations);
    return Redirect::action('RegistrationsController@index');
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
        //dd(date('F d, Y', strtotime(NULL)));
        $registration= \montserrat\Registration::find($id);
        $retreat = \montserrat\Retreat::findOrFail($registration->retreat_id);
        $retreatant = \montserrat\Person::findOrFail($registration->retreatant_id);
       return view('registrations.show',compact('registration','retreat','retreatant'));//
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
        $registration= \montserrat\Registration::findOrFail($id);
//        $retreat = \montserrat\Retreat::findOrFail($registration->retreat_id);
//        $retreatant = \montserrat\Retreatant::findOrFail($registration->retreatant_id);
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start,"%m-%d-%Y"),")") as description'), 'id')->where("end",">",\Carbon\Carbon::today())->orderBy('start')->lists('description','id');
        $retreatants = \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_retreatant','=','1')->orderBy('fullname')->lists('fullname','id');

        
        return view('registrations.edit',compact('registration','retreats','retreatants'));
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
        'register' => 'required|date',
        'confirmattend' => 'date',
        'confirmregister' => 'date',
        'retreat_id' => 'required|integer|min:0',
        'retreatant_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:1000',
        ]);


    $registration = \montserrat\Registration::findOrFail($request->input('id'));
    $retreat = \montserrat\Retreat::findOrFail($request->input('retreat_id'));

    $registration->retreat_id= $request->input('retreat_id');
    $registration->start = $retreat->start;
    $registration->end = $retreat->end;
    $registration->retreatant_id= $request->input('retreatant_id');
    $registration->register = $request->input('register');
    $registration->confirmattend = $request->input('confirmattend');
    $registration->confirmregister = $request->input('confirmregister');
    $registration->confirmedby = $request->input('confirmedby');
    $registration->deposit = $request->input('deposit');
    $registration->notes = $request->input('notes');
    $registration->save();
    
    return Redirect::action('RegistrationsController@index');
    
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
         $registration= \montserrat\Registration::findOrFail($id);
         $retreat = \montserrat\Retreat::findOrFail($registration->retreat_id);
         
        \montserrat\Registration::destroy($id);
        $countregistrations = \montserrat\Registration::where('retreat_id','=',$registration->retreat_id)->count();
        $retreat->attending = $countregistrations;
        $retreat->save();
        return Redirect::action('RegistrationsController@index');
    }
}
