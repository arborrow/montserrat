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
        $registrations = \montserrat\Registration::whereHas('retreat', function($query) {
            $query->where('end_date','>=',date('Y-m-d'));
            
        })->orderBy('register_date','desc')->with('retreatant','retreat','room')->get();
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
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->pluck('idnumber','title','id');
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today()->subWeek())->orderBy('start_date')->pluck('description','id');
        $retreats->prepend('Unassigned',0);
        $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->pluck('sort_name','id');
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
        
        $dt_today =  \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        $defaults['retreat_id']=0;
        
        return view('registrations.create',compact('retreats','retreatants','rooms','defaults')); 
        
    }

    public function add($id)
    {
        //
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->pluck('idnumber','title','id');
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today()->subWeek())->orderBy('start_date')->pluck('description','id');
        $retreats->prepend('Unassigned',0);
        $retreatant = \montserrat\Contact::findOrFail($id);
        if ($retreatant->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->pluck('sort_name','id');
        }
        if ($retreatant->contact_type == CONTACT_TYPE_ORGANIZATION) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_ORGANIZATION)->whereSubcontactType($retreatant->subcontact_type)->orderBy('sort_name')->pluck('sort_name','id');
        }
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
        
        $defaults['contact_id']=$id;
        $defaults['retreat_id']=0;
        $dt_today =  \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        
        return view('registrations.create',compact('retreats','retreatants','rooms','defaults')); 
        //dd($retreatants);
    }

    public function add_group($id)
    {
        //
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->pluck('idnumber','title','id');
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today()->subWeek())->orderBy('start_date')->pluck('description','id');
        $retreats->prepend('Unassigned',0);
        $groups = \montserrat\Group::orderBy('title')->pluck('title','id');
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
        
        $defaults['group_id']=$id;
        $defaults['retreat_id']=0;
        $dt_today =  \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        
        return view('registrations.add_group',compact('retreats','groups','rooms','defaults')); 
        //dd($retreatants);
    }

        public function register($retreat_id = 0, $contact_id = 0)
    {
        //
        //$retreats = \montserrat\Retreat::where('end','>',\Carbon\Carbon::today())->pluck('idnumber','title','id');

        if ($retreat_id > 0) {
            $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today())->whereId($retreat_id)->orderBy('start_date')->pluck('description','id');
        } else {
            $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today())->orderBy('start_date')->pluck('description','id');
        }
        $retreats->prepend('Unassigned',0);
        
        if ($contact_id > 0) {
            $retreatants = \montserrat\Contact::whereId($contact_id)->orderBy('sort_name')->pluck('sort_name','id');
        } else {
            $retreatants = \montserrat\Contact::orderBy('sort_name')->pluck('sort_name','id');
        }
        $retreatants->prepend('Unassigned',0);
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
        
        $dt_today =  \Carbon\Carbon::today();
        $defaults['retreat_id'] = $retreat_id;
        $defaults['contact_id'] = $contact_id;
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        
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
    $this->validate($request, [
        'register_date' => 'required|date',
        'attendance_confirm_date' => 'date',
        'registration_confirm_date' => 'date',
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'event_id' => 'required|integer|min:1',
        'contact_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:10000',
        ]);
    
    $rooms = $request->input('rooms');
    //TODO: Should we check and verify that the contact type is an organization to allow multiselect or just allow any registration to book multiple rooms?
    $retreat = \montserrat\Retreat::findOrFail($request->input('event_id'));
    $contact = \montserrat\Contact::findOrFail($request->input('contact_id'));
    foreach($rooms as $room) {
        //ensure that it is a valid room (not N/A)
        $registration = new \montserrat\Registration;
        $registration->event_id= $request->input('event_id');
        $registration->contact_id= $request->input('contact_id');
        $registration->register_date = $request->input('register_date');
        $registration->attendance_confirm_date = $request->input('attendance_confirm_date');
        if (!empty($request->input('canceled_at'))) {$registration->canceled_at= $request->input('canceled_at'); }
        if (!empty($request->input('arrived_at'))) {$registration->arrived_at = $request->input('arrived_at'); }
        if (!empty($request->input('departed_at'))) {$registration->departed_at = $request->input('departed_at'); }
        $registration->room_id= $room;
        $registration->registration_confirm_date= $request->input('registration_confirm_date');
        $registration->confirmed_by = $request->input('confirmed_by');
        $registration->deposit = $request->input('deposit');
        $registration->notes = $request->input('notes');
        $registration->save();
        //TODO: verify that the newly created room assignment does not conflict with an existing one
    }
    
    return Redirect::action('RegistrationsController@index');
    }

    public function store_group(Request $request)
    {
    $this->validate($request, [
        'register_date' => 'required|date',
        'attendance_confirm_date' => 'date',
        'registration_confirm_date' => 'date',
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'event_id' => 'required|integer|min:0',
        'group_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:10000',
        ]);
    
    $retreat = \montserrat\Retreat::findOrFail($request->input('event_id'));
    $group_members = \montserrat\GroupContact::whereGroupId($request->input('group_id'))->whereStatus('Added')->get();
    foreach($group_members as $group_member) {
        //ensure that it is a valid room (not N/A)
        $registration = new \montserrat\Registration;
        $registration->event_id= $request->input('event_id');
        $registration->contact_id= $group_member->contact_id;
        $registration->register_date = $request->input('register_date');
        $registration->attendance_confirm_date = $request->input('attendance_confirm_date');
        if (!empty($request->input('canceled_at'))) {$registration->canceled_at= $request->input('canceled_at'); }
        if (!empty($request->input('arrived_at'))) {$registration->arrived_at = $request->input('arrived_at'); }
        if (!empty($request->input('departed_at'))) {$registration->departed_at = $request->input('departed_at'); }
        $registration->room_id= 0;
        $registration->registration_confirm_date= $request->input('registration_confirm_date');
        $registration->confirmed_by = $request->input('confirmed_by');
        $registration->deposit = $request->input('deposit');
        $registration->notes = $request->input('notes');
        $registration->save();
        //TODO: verify that the newly created room assignment does not conflict with an existing one
    }
    
    return Redirect::action('RetreatsController@show'
            . '',$retreat->id);
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
        $registration= \montserrat\Registration::with('retreat','retreatant','room')->findOrFail($id);
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
//        $retreat = \montserrat\Retreat::findOrFail($registration->event_id);
        $retreatant = \montserrat\Contact::findOrFail($registration->contact_id);
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today())->orderBy('start_date')->pluck('description','id');
        //dd($retreats);
        //TODO: we will want to be able to switch between types when going from a group registration to individual room assignment
        if ($retreatant->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->pluck('sort_name','id');
        }
        if ($retreatant->contact_type == CONTACT_TYPE_ORGANIZATION) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_ORGANIZATION)->whereSubcontactType($retreatant->subcontact_type)->orderBy('sort_name')->pluck('sort_name','id');
        }
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
    
        /* Check to see if the current registration is for a past retreat and if so, add it to the collection */
        // $retreats[0] = 'Unassigned';
        
        if ($registration->retreat->end < \Carbon\Carbon::now()) {
            
            $retreats[$registration->event_id] = $registration->retreat->idnumber.'-'.$registration->retreat->title." (".date('m-d-Y', strtotime($registration->retreat->start_date)).")";
        }
        return view('registrations.edit',compact('registration','retreats','rooms'));
    }

    public function edit_group($id)
    {
        //
        $registration= \montserrat\Registration::with('retreatant','retreat','room')->findOrFail($id);
//        $retreat = \montserrat\Retreat::findOrFail($registration->event_id);
        $retreatant = \montserrat\Contact::findOrFail($registration->contact_id);
        $retreats = \montserrat\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date",">",\Carbon\Carbon::today())->orderBy('start_date')->pluck('description','id');
        //dd($retreats);
        //TODO: we will want to be able to switch between types when going from a group registration to individual room assignment
        if ($retreatant->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->pluck('sort_name','id');
        }
        if ($retreatant->contact_type == CONTACT_TYPE_ORGANIZATION) {
            $retreatants = \montserrat\Contact::whereContactType(CONTACT_TYPE_ORGANIZATION)->whereSubcontactType($retreatant->subcontact_type)->orderBy('sort_name')->pluck('sort_name','id');
        }
        
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
    
        /* Check to see if the current registration is for a past retreat and if so, add it to the collection */
        // $retreats[0] = 'Unassigned';
        
        if ($registration->retreat->end < \Carbon\Carbon::now()) {
            
            $retreats[$registration->event_id] = $registration->retreat->idnumber.'-'.$registration->retreat->title." (".date('m-d-Y', strtotime($registration->retreat->start_date)).")";
        }
        return view('registrations.edit_group',compact('registration','retreats','rooms','retreatants'));
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
        'register_date' => 'required|date',
        'attendance_confirm_date' => 'date',
        'registration_confirm_date' => 'date',
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'event_id' => 'required|integer|min:0',
        'room_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:10000',
        ]);


    $registration = \montserrat\Registration::findOrFail($request->input('id'));
    $retreat = \montserrat\Retreat::findOrFail($request->input('event_id'));

    $registration->event_id= $request->input('event_id');
    // TODO: pull this from the retreat's start_date and end_date
    //$registration->start = $retreat->start;
    //$registration->end = $retreat->end;
    //$registration->contact_id= $request->input('contact_id');
    $registration->register_date = $request->input('register_date');
    $registration->attendance_confirm_date = $request->input('attendance_confirm_date');
    $registration->registration_confirm_date = $request->input('registration_confirm_date');
    $registration->confirmed_by = $request->input('confirmed_by');
    $registration->deposit = $request->input('deposit');
    $registration->notes = $request->input('notes');
    $registration->canceled_at = $request->input('canceled_at');
    $registration->arrived_at= $request->input('arrived_at');
    $registration->departed_at= $request->input('departed_at');
    
    $registration->room_id= $request->input('room_id');
    $registration->save();
    
    return Redirect::action('RegistrationsController@index');
    
    }
    public function update_group(Request $request, $id)
    {
        //
    $this->validate($request, [
        'register_date' => 'required|date',
        'attendance_confirm_date' => 'date',
        'registration_confirm_date' => 'date',
        'canceled_at' => 'date',
        'arrived_at' => 'date',
        'departed_at' => 'date',
        'contact_id' => 'required|integer|min:0',
        'event_id' => 'required|integer|min:0',
        'room_id' => 'required|integer|min:0',
        'deposit' => 'required|numeric|min:0|max:10000',
        ]);


    $registration = \montserrat\Registration::findOrFail($request->input('id'));
    $retreat = \montserrat\Retreat::findOrFail($request->input('event_id'));

    $registration->event_id= $request->input('event_id');
    // TODO: pull this from the retreat's start_date and end_date
    //$registration->start = $retreat->start;
    //$registration->end = $retreat->end;
    $registration->contact_id= $request->input('contact_id');
    $registration->register_date = $request->input('register_date');
    $registration->attendance_confirm_date = $request->input('attendance_confirm_date');
    $registration->registration_confirm_date = $request->input('registration_confirm_date');
    $registration->confirmed_by = $request->input('confirmed_by');
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
         $retreat = \montserrat\Retreat::findOrFail($registration->event_id);
         
        \montserrat\Registration::destroy($id);
        $countregistrations = \montserrat\Registration::where('event_id','=',$registration->event_id)->count();
        //$retreat->attending = $countregistrations;
        $retreat->save();
        return Redirect::action('RegistrationsController@index');
    }
    public function confirm($id) {
        $registration = \montserrat\Registration::findOrFail($id);
        $registration->registration_confirm_date = \Carbon\Carbon::now();
        $registration->save();
        return Redirect::back();
    }
       
    public function attend($id) {
        $registration = \montserrat\Registration::findOrFail($id);
        $registration->attendance_confirm_date = \Carbon\Carbon::now();
        $registration->save();
        return Redirect::back();
    }
    
    public function arrive($id) {
        $registration = \montserrat\Registration::findOrFail($id);
        $registration->arrived_at = \Carbon\Carbon::now();
        $registration->save();
        return Redirect::back();
    }
    
    public function depart($id) {
        $registration = \montserrat\Registration::findOrFail($id);
        $registration->departed_at = \Carbon\Carbon::now();
        $registration->save();
        return Redirect::back();
    }
    public function cancel($id) {
        $registration = \montserrat\Registration::findOrFail($id);
        $registration->canceled_at = \Carbon\Carbon::now();
        $registration->save();
        return Redirect::back();
    }
}