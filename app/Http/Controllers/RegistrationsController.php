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
        $registrations = \montserrat\Registration::whereDate('end', '>=', date('Y-m-d'))->orderBy('start','asc')->with('retreatant','retreat','room')->get();
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
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start,"%m-%d-%Y"),")") as description'), 'id')->where("end",">",\Carbon\Carbon::today())->orderBy('start')->pluck('description','id');
        $retreats->prepend('Unassigned',0);
        $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->lists('sort_name','id');
        $rooms= \montserrat\Room::orderby('name')->lists('name','id');
        
        return view('registrations.create',compact('retreats','retreatants','rooms')); 
        //dd($retreatants);
    }

    public function add($id)
    {
        //
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->lists('idnumber','title','id');
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start,"%m-%d-%Y"),")") as description'), 'id')->where("end",">",\Carbon\Carbon::today())->orderBy('start')->pluck('description','id');
        $retreats->prepend('Unassigned',0);
        $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->lists('sort_name','id');
        $rooms= \montserrat\Room::orderby('name')->lists('name','id');
        $defaults['retreatant_id']=$id;
        return view('registrations.create',compact('retreats','retreatants','rooms','defaults')); 
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
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'retreat_id' => 'required|integer|min:0',
        'retreatant_id' => 'required|integer|min:0',
        'room_id' => 'required|integer|min:0',
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
    if (!empty($request->input('canceled_at'))) {$registration->canceled_at= $request->input('canceled_at'); }
    if (!empty($request->input('arrived_at'))) {$registration->arrived_at = $request->input('arrived_at'); }
    if (!empty($request->input('departed_at'))) {$registration->departed_at = $request->input('departed_at'); }
    $registration->room_id= $request->input('room_id');
    
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
        $registration= \montserrat\Registration::with('retreat','retreatant','room')->find($id);
        //dd($registration);
       return view('registrations.show',compact('registration'));//
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
        $registration= \montserrat\Registration::with('retreatant','retreat','room')->findOrFail($id);
//        $retreat = \montserrat\Retreat::findOrFail($registration->retreat_id);
//        $retreatant = \montserrat\Retreatant::findOrFail($registration->retreatant_id);
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start,"%m-%d-%Y"),")") as description'), 'id')->where("end",">",\Carbon\Carbon::today())->orderBy('start')->pluck('description','id');
        //dd($retreats);
        $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->lists('sort_name','id');
        $rooms= \montserrat\Room::orderby('name')->lists('name','id');
        /* Check to see if the current registration is for a past retreat and if so, add it to the collection */
        // $retreats[0] = 'Unassigned';
        
        if ($registration->retreat->end < \Carbon\Carbon::now()) {
            
            $retreats[$registration->retreat_id] = $registration->retreat->idnumber.'-'.$registration->retreat->title." (".date('m-d-Y', strtotime($registration->retreat->start)).")";
        }
        return view('registrations.edit',compact('registration','retreats','retreatants','rooms'));
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
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'retreat_id' => 'required|integer|min:0',
        'retreatant_id' => 'required|integer|min:0',
        'room_id' => 'required|integer|min:0',
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
    $registration->canceled_at = $request->input('canceled_at');
    $registration->arrived_at= $request->input('arrived_at');
    $registration->departed_at= $request->input('departed_at');
    
    $registration->room_id= $request->input('room_id');
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
