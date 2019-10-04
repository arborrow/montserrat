<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Image;
use App\Http\Controllers\AttachmentController;

class RetreatController extends Controller
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
        $this->authorize('show-retreat');
        $defaults = [];
        $defaults['type']='Retreat';
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('id', 'name');

        $retreats = \App\Retreat::whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date', 'asc')->with('retreatmasters.prefix', 'retreatmasters.suffix', 'innkeeper.prefix','innkeeper.suffix', 'assistant.prefix','assistant.suffix')->get();
        $oldretreats = \App\Retreat::whereDate('end_date', '<', date('Y-m-d'))->orderBy('start_date', 'desc')->with('retreatmasters', 'innkeeper', 'assistant')->paginate(100);
        return view('retreats.index', compact('retreats', 'oldretreats', 'defaults', 'event_types'));   //
    }
    public function index_type($event_type_id)
    {
        $this->authorize('show-retreat');
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('id', 'name');
        $event_type = \App\EventType::findOrFail($event_type_id);
        $defaults = [];
        $defaults['type'] = $event_type->label;
        $retreats = \App\Retreat::type($event_type_id)->whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date', 'asc')->with('retreatmasters', 'innkeeper', 'assistant')->get();
        $oldretreats = \App\Retreat::type($event_type_id)->whereDate('end_date', '<', date('Y-m-d'))->orderBy('start_date', 'desc')->with('retreatmasters', 'innkeeper', 'assistant')->paginate(100);
        return view('retreats.index', compact('retreats', 'oldretreats', 'defaults', 'event_types'));   //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-retreat');

        $retreat_house = \App\Contact::with('retreat_directors.contact_b', 'retreat_innkeepers.contact_b', 'retreat_assistants.contact_b', 'retreat_captains.contact_b')->findOrFail(config('polanco.contact.montserrat'));
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');
        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b]=$innkeeper->contact_b->sort_name;
        }
        asort($i);
        $i=[0=>'N/A']+$i;

        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b]=$director->contact_b->sort_name;
        }
        asort($d);
        $d=[0=>'N/A']+$d;

        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b]=$assistant->contact_b->sort_name;
        }
        asort($a);
        $a=[0=>'N/A']+$a;

        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b]=$captain->contact_b->sort_name;
        }
        asort($c);
        $c=[0=>'N/A']+$c;
        //dd($retreat_house);
        return view('retreats.create', compact('d', 'i', 'a', 'c', 'event_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-retreat');
        $this->validate($request, [
            'idnumber' => 'required|unique:event,idnumber',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean',
            'is_active' => 'boolean'
          ]);

        $retreat = new \App\Retreat;
        $calendar_event = new Event;

        $retreat->idnumber = $request->input('idnumber');
        $retreat->start_date = $request->input('start_date');
        $retreat->end_date = $request->input('end_date');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->event_type_id = $request->input('event_type');
        $retreat->is_active = 1; #assume active event upon creation
        // TODO: find a way to tag silent retreats, perhaps with event_type_id - for now disabled
        //$retreat->silent = $request->input('silent');
        // amount will be related to default_fee_id?
        //$retreat->amount = $request->input('amount');
        // attending should be calculated based on retreat participants
        // TODO: consider making Directors, Innkeepers, and Assistants participant roles and adding them by default to retreats
        //$retreat->attending = $request->input('attending');
        //$retreat->year = $request->input('year');
        $retreat->innkeeper_id = $request->input('innkeeper_id');
        $retreat->assistant_id = $request->input('assistant_id');
        $calendar_event->id = uniqid();
        $retreat->calendar_id = $calendar_event->id;
        $retreat->save();

        if (empty($request->input('directors')) or in_array(0, $request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }

        if (empty($request->input('captains')) or in_array(0, $request->input('captains'))) {
            $retreat->captains()->detach();
        } else {
            $retreat->captains()->sync($request->input('captains'));
        }

        $calendar_event->name = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
        $calendar_event->summary = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
        $calendar_event->startDateTime = $retreat->start_date;
        $calendar_event->endDateTime = $retreat->end_date;
        $retreat_url = url('retreat/'.$retreat->id);
        $calendar_event->description = "<a href='". $retreat_url . "'>".$retreat->idnumber." - ".$retreat->title."</a> : " .$retreat->description;
        $calendar_event->save('insertEvent');



        return Redirect::action('RetreatController@index');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $status = NULL)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->findOrFail($id);

        switch ($status) {
            case 'active':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNull('canceled_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'cancel':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('canceled_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'confirm':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->whereEventId($id)->
                  whereNotNull('registration_confirm_date')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'arrive':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('arrived_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'depart':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('departed_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            default:
//                $registrations = \App\Registration::whereEventId($id)->whereNull('canceled_at')->with('retreatant.parish')->paginate(100);
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact','participant.contact_id','=','contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  withCount('retreatant_events')->
                  paginate(50);
                 // dd($registrations);
                break;
        }

        return view('retreats.show', compact('retreat', 'registrations','status'));//
    }

    public function show_waitlist($id)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereStatusId(config('polanco.registration_status_id.waitlist'))->with('retreatant.parish')->orderBy('register_date', 'ASC')->get();
        return view('retreats.waitlist', compact('retreat', 'registrations'));//
    }

    public function get_event_by_id_number($id_number, $status=NULL)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->whereIdnumber($id_number)->firstOrFail();
        return $this->show($retreat->id,$status);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function edit($id)
    //{
    //   $retreats = \App\Retreat::();
    //   return view('retreats.edit',compact('retreats'));
    //  }
    public function edit($id)
    {
        $this->authorize('update-retreat');
        //get this retreat's information
        $retreat = \App\Retreat::with('retreatmasters', 'assistant', 'innkeeper', 'captains')->findOrFail($id);
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');
        $is_active[0]='Cancelled';
        $is_active[1]='Active';

        //create lists of retreat directors, innkeepers, and assistants from relationship to retreat house
        $retreat_house = \App\Contact::with('retreat_directors.contact_b', 'retreat_innkeepers.contact_b', 'retreat_assistants.contact_b')->findOrFail(config('polanco.contact.montserrat'));

        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b]=$innkeeper->contact_b->sort_name;
        }
        asort($i);
        $i=[0=>'N/A']+$i;

        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b]=$director->contact_b->sort_name;
        }
        asort($d);
        $d=[0=>'N/A']+$d;

        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b]=$assistant->contact_b->sort_name;
        }
        asort($a);
        $a=[0=>'N/A']+$a;

        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b]=$captain->contact_b->sort_name;
        }
        asort($c);
        $c=[0=>'N/A']+$c;

        /* prevent losing former retreatmasters, innkeeper, assistant, or captain when editing retreat
         * loop through currently assigned retreatmasters, innkeeper, assistant, and captain assignments
         * verify that they are currently in appropriate array as defined above (d, i, a or c)
         * if not found in the array then add them and resort the array adding 'former' to the end of their name
         * so that they visually standout on the dropdown list as being a former member of that group
         */

        foreach ($retreat->retreatmasters as $director) {
            if (!array_has($d,$director->id)) {
                $d[$director->id] = $director->sort_name. ' (former)';
                asort($d);
                // dd($director->sort_name.' is not currently a retreat director: '.$director->id, $d);
            }
        }

        if (isset($retreat->innkeeper->id)) {
            if (!array_has($i,$retreat->innkeeper->id)) {
                $i[$retreat->innkeeper->id] = $retreat->innkeeper->sort_name. ' (former)';
                asort($i);
                // dd($retreat->innkeeper->sort_name.' is not currently an innkeeper: '.$retreat->innkeeper->id, $i);
            }
        }

        if (isset($retreat->assistant->id)) {
           if (!array_has($a,$retreat->assistant->id)) {
                $a[$retreat->assistant->id] = $retreat->assistant->sort_name. ' (former)';
                asort($a);
                // dd($retreat->assistant->sort_name.' is not currently an assistant: '.$retreat->assistant->id, $a);
            }
        }


        foreach ($retreat->captains as $captain) {
            if (!array_has($c,$captain->id)) {
                $c[$captain->id] = $captain->sort_name. ' (former)';
                asort($c);
                // dd($captain->sort_name.' is not currently a captain: '.$captain->id, $c);

            }
        }

        return view('retreats.edit', compact('retreat', 'd', 'i', 'a', 'c', 'event_types', 'is_active'));
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
        $this->authorize('update-retreat');
        $this->validate($request, [
            'idnumber' => 'required|unique:event,idnumber,'.$id,
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean',
            'is_active' => 'boolean',
            'contract' => 'file|mimes:pdf|max:5000|nullable',
            'schedule' => 'file|mimes:pdf|max:5000|nullable',
            'evaluations' => 'file|mimes:pdf|max:10000|nullable',
            'group_photo' => 'image|max:10000|nullable',

        ]);

        $retreat = \App\Retreat::findOrFail($request->input('id'));
        $retreat->idnumber = $request->input('idnumber');
        $retreat->start_date = $request->input('start_date');
        $retreat->end_date = $request->input('end_date');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->event_type_id = $request->input('event_type');
        $retreat->is_active = $request->input('is_active');
        //TODO: Figure out how to use event type or some other way of tracking the silent retreats, possibly silent boolean field in event table
        //$retreat->silent = $request->input('silent');
        //$retreat->amount = $request->input('amount');
        // attending field not needed - will calculate with count on registrations
        //$retreat->attending = $request->input('attending');
        //$retreat->year = $request->input('year');
        $retreat->innkeeper_id = $request->input('innkeeper_id');
        $retreat->assistant_id = $request->input('assistant_id');
        if (null !==$request->input('calendar_id')) {
            $retreat->calendar_id = $request->input('calendar_id');
        }
        $retreat->save();

        if (null !== $request->file('contract')) {
            $description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('contract'), 'event', $retreat->id, 'contract', $description);
        }

        if (null !== $request->file('schedule')) {
            $description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('schedule'), 'event', $retreat->id, 'schedule', $description);
        }

        if (null !== $request->file('evaluations')) {
            $description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('evaluations'), 'event', $retreat->id, 'evaluations', $description);
        }

        if (null !== $request->file('group_photo')) {
            $description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('group_photo'), 'event', $retreat->id, 'group_photo', $description);
        }

        if (empty($request->input('directors')) or in_array(0, $request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }
        if (empty($request->input('captains')) or in_array(0, $request->input('captains'))) {
            $retreat->captains()->detach();
        } else {
            $retreat->captains()->sync($request->input('captains'));
        }
        if (!empty($retreat->calendar_id)) {
            //dd($retreat->calendar_id);
            $calendar_event = Event::find($retreat->calendar_id);
            /*
             * Initial work to manage attendees from Polanco
             * Need to clean up management of primary emails
             * Should this be limited to montserratretreat.org emails?
             * What about guest directors?
             */
            //$calendar_event->attendees = $retreat->retreat_attendees;
            if (!empty($calendar_event)) {
                $calendar_event->name = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
                $calendar_event->summary = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
                $calendar_event->startDateTime = $retreat->start_date;
                $calendar_event->endDateTime = $retreat->end_date;
                $retreat_url = url('retreat/'.$retreat->id);
                $calendar_event->description = "<a href='". $retreat_url . "'>".$retreat->idnumber." - ".$retreat->title."</a> : " .$retreat->description;
                //dd($calendar_event);
                $calendar_event->save();
            }
        }


        return Redirect::action('RetreatController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-retreat');
        $retreat = \App\Retreat::findOrFail($id);

        if (!empty($retreat->calendar_id)) {
            $calendar_event = Event::find($retreat->calendar_id);
            if (!empty($calendar_event)) {
                $calendar_event->name = '[CANCELLED] '.$retreat->title. ' ('.$retreat->idnumber.')';
                $calendar_event->save();
            }
        }
        $calendar_event = Event::find($retreat->calendar_id);
        $calendar_event->delete();
        \App\Retreat::destroy($id);

        return Redirect::action('RetreatController@index');
    }


    public function assign_rooms($id)
    {
        $this->authorize('update-registration');
        //get this retreat's information
        $retreat = \App\Retreat::with('retreatmasters', 'assistant', 'innkeeper', 'captains')->findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->with('retreatant.parish')->orderBy('register_date', 'DESC')->get();
        $rooms= \App\Room::orderby('name')->pluck('name', 'id');
        $rooms->prepend('Unassigned', 0);

        return view('retreats.assign_rooms', compact('retreat', 'registrations', 'rooms'));
    }

    public function edit_payments($id)
    {
        $this->authorize('update-payment');
        //get this retreat's information
        $retreat = \App\Retreat::findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereCanceledAt(null)->with('retreatant.parish','donation')->orderBy('register_date', 'DESC')->get();
        $payment_description = config('polanco.payment_method');
        $donation_description = \App\DonationType::whereIsActive(1)->orderby('name')->pluck('name', 'id');
        $donation_description->prepend('Unassigned', 0);

        return view('retreats.payments.edit', compact('retreat', 'registrations', 'donation_description','payment_description'));
    }
    public function show_payments($id)
    {
        $this->authorize('show-payment');
        $retreat = \App\Retreat::findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereCanceledAt(null)->with('retreatant.parish','donation')->orderBy('register_date', 'DESC')->get();
        return view('retreats.payments.show', compact('retreat', 'registrations'));
    }

    public function checkout($id)
    {
        /* checkout all registrations for a retreat where the arrived_at is not NULL and the departed is NULL for a particular event */
        $this->authorize('update-registration');
        $retreat = \App\Retreat::findOrFail($id); //verifies that it is a valid retreat id
        $registrations = \App\Registration::whereEventId($id)->whereCanceledAt(null)->whereDepartedAt(null)->whereNotNull('arrived_at')->get();
        foreach ($registrations as $registration) {
                $registration->departed_at = $registration->retreat_end_date;
                $registration->save();
        }
        return Redirect::back();
    }
    public function checkin($id)
    {
        /* checkout all registrations for a retreat where the arrived_at is not NULL and the departed is NULL for a particular event */
        $this->authorize('update-registration');
        $retreat = \App\Retreat::findOrFail($id); //verifies that it is a valid retreat id
        $registrations = \App\Registration::whereEventId($id)->whereCanceledAt(null)->whereDepartedAt(null)->whereNull('arrived_at')->get();
        foreach ($registrations as $registration) {
                $registration->arrived_at = $registration->retreat_start_date;
                $registration->save();
        }
        return Redirect::back();
    }


    public function room_update(Request $request)
    {
        $this->authorize('update-registration');
        $this->validate($request, [
            'retreat_id' => 'integer|min:0',

        ]);
        if (null !== $request->input('registrations')) {
            foreach ($request->input('registrations') as $key => $value) {
                $registration = \App\Registration::findOrFail($key);
                $registration->room_id = $value;
                $registration->save();
                //dd($registration,$value);
            }
        }
        if (null !== $request->input('notes')) {
            foreach ($request->input('notes') as $key => $value) {
                $registration = \App\Registration::findOrFail($key);
                $registration->notes = $value;
                $registration->save();
                //dd($registration,$value);
            }
        }
        return Redirect::action('RetreatController@index');
    }
    public function calendar()
    {   $this->authorize('show-retreat');
        $calendar_events = \Spatie\GoogleCalendar\Event::get();
        return view('calendar.index', compact('calendar_events'));
    }
}
