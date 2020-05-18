<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomUpdateRetreatRequest;
use App\Http\Requests\StoreRetreatRequest;
use App\Http\Requests\UpdateRetreatRequest;
use App\Registration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;

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
        $defaults['type'] = 'Retreat';
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('id', 'name');

        $retreats = \App\Retreat::whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date', 'asc')->with('retreatmasters.prefix', 'retreatmasters.suffix', 'innkeeper.prefix', 'innkeeper.suffix', 'assistant.prefix', 'assistant.suffix')->get();
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

        $retreat_house = \App\Contact::with('retreat_directors.contact_b', 'retreat_innkeepers.contact_b', 'retreat_assistants.contact_b', 'retreat_captains.contact_b')->findOrFail(config('polanco.self.id'));
        $event_types = \App\EventType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');

        // initialize null arrays for innkeeper, assistant, director and captain dropdowns
        $i = [];
        $a = [];
        $d = [];
        $c = [];

        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b] = $innkeeper->contact_b->sort_name;
        }
        if (! null == $i) {
            asort($i);
            $i = [0=>'N/A'] + $i;
        }

        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b] = $director->contact_b->sort_name;
        }
        if (! null == $d) {
            asort($d);
            $d = [0=>'N/A'] + $d;
        }

        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b] = $assistant->contact_b->sort_name;
        }
        if (! null == $a) {
            asort($a);
            $a = [0=>'N/A'] + $a;
        }

        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b] = $captain->contact_b->sort_name;
        }
        if (! null == $c) {
            asort($c);
            $c = [0=>'N/A'] + $c;
        }
        //dd($retreat_house);
        return view('retreats.create', compact('d', 'i', 'a', 'c', 'event_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRetreatRequest $request)
    {
        $this->authorize('create-retreat');

        $retreat = new \App\Retreat;

        $retreat->idnumber = $request->input('idnumber');
        $retreat->start_date = $request->input('start_date');
        $retreat->end_date = $request->input('end_date');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->event_type_id = $request->input('event_type');
        $retreat->is_active = 1; //assume active event upon creation
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

        if (null !== (config('settings.google_calendar_id'))) {
            $calendar_event = new Event;
            $calendar_event->id = uniqid();
            $retreat->calendar_id = $calendar_event->id;
        }

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

        if (null !== (config('settings.google_calendar_id'))) {
            $calendar_event->name = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
            $calendar_event->summary = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
            $calendar_event->startDateTime = $retreat->start_date;
            $calendar_event->endDateTime = $retreat->end_date;
            $retreat_url = url('retreat/'.$retreat->id);
            $calendar_event->description = "<a href='".$retreat_url."'>".$retreat->idnumber.' - '.$retreat->title.'</a> : '.$retreat->description;
            $calendar_event->save('insertEvent');
        }

        return Redirect::action('RetreatController@index'); //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $status = null)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->findOrFail($id);
        $attachments = \App\Attachment::whereEntity('event')->whereEntityId($id)->whereFileTypeId(config('polanco.file_type.event_attachment'))->get();

        switch ($status) {
            case 'active':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNull('canceled_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'cancel':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('canceled_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'confirm':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->whereEventId($id)->
                  whereNotNull('registration_confirm_date')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'arrive':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('arrived_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            case 'depart':
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  whereNotNull('departed_at')->
                  withCount('retreatant_events')->
                  paginate(50);
                break;
            default:
//                $registrations = \App\Registration::whereEventId($id)->whereNull('canceled_at')->with('retreatant.parish')->paginate(100);
                $registrations = \App\Registration::select('participant.*', 'contact.sort_name')->
                  leftjoin('contact', 'participant.contact_id', '=', 'contact.id')->
                  orderBy('contact.sort_name')->
                  whereEventId($id)->
                  withCount('retreatant_events')->
                  paginate(50);
                 // dd($registrations);
                break;
        }

        return view('retreats.show', compact('retreat', 'registrations', 'status', 'attachments')); //
    }

    public function show_waitlist($id)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereStatusId(config('polanco.registration_status_id.waitlist'))->with('retreatant.parish')->orderBy('register_date', 'ASC')->get();

        return view('retreats.waitlist', compact('retreat', 'registrations')); //
    }

    public function get_event_by_id_number($id_number, $status = null)
    {
        $this->authorize('show-retreat');
        $retreat = \App\Retreat::with('retreatmasters', 'innkeeper', 'assistant', 'captains')->whereIdnumber($id_number)->firstOrFail();

        return $this->show($retreat->id, $status);
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
        $is_active[0] = 'Cancelled';
        $is_active[1] = 'Active';

        //create lists of retreat directors, innkeepers, and assistants from relationship to retreat house
        $retreat_house = \App\Contact::with('retreat_directors.contact_b', 'retreat_innkeepers.contact_b', 'retreat_assistants.contact_b')->findOrFail(config('polanco.self.id'));

        // initialize null arrays for innkeeper, assistant, director and captain dropdowns
        $i = [];
        $a = [];
        $d = [];
        $c = [];

        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b] = $innkeeper->contact_b->sort_name;
        }
        if (! null == $i) {
            asort($i);
            $i = [0=>'N/A'] + $i;
        }

        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b] = $director->contact_b->sort_name;
        }
        if (! null == $d) {
            asort($d);
            $d = [0=>'N/A'] + $d;
        }

        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b] = $assistant->contact_b->sort_name;
        }
        if (! null == $a) {
            asort($a);
            $a = [0=>'N/A'] + $a;
        }

        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b] = $captain->contact_b->sort_name;
        }
        if (! null == $c) {
            asort($c);
            $c = [0=>'N/A'] + $c;
        }

        /* prevent losing former retreatmasters, innkeeper, assistant, or captain when editing retreat
         * loop through currently assigned retreatmasters, innkeeper, assistant, and captain assignments
         * verify that they are currently in appropriate array as defined above (d, i, a or c)
         * if not found in the array then add them and resort the array adding 'former' to the end of their name
         * so that they visually standout on the dropdown list as being a former member of that group
         */

        foreach ($retreat->retreatmasters as $director) {
            if (! Arr::has($d, $director->id)) {
                $d[$director->id] = $director->sort_name.' (former)';
                asort($d);
                // dd($director->sort_name.' is not currently a retreat director: '.$director->id, $d);
            }
        }

        if (isset($retreat->innkeeper->id)) {
            if (! Arr::has($i, $retreat->innkeeper->id)) {
                $i[$retreat->innkeeper->id] = $retreat->innkeeper->sort_name.' (former)';
                asort($i);
                // dd($retreat->innkeeper->sort_name.' is not currently an innkeeper: '.$retreat->innkeeper->id, $i);
            }
        }

        if (isset($retreat->assistant->id)) {
            if (! Arr::has($a, $retreat->assistant->id)) {
                $a[$retreat->assistant->id] = $retreat->assistant->sort_name.' (former)';
                asort($a);
                // dd($retreat->assistant->sort_name.' is not currently an assistant: '.$retreat->assistant->id, $a);
            }
        }

        foreach ($retreat->captains as $captain) {
            if (! Arr::has($c, $captain->id)) {
                $c[$captain->id] = $captain->sort_name.' (former)';
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
    public function update(UpdateRetreatRequest $request, $id)
    {
        $this->authorize('update-retreat');

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
        if (null !== $request->input('calendar_id')) {
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

        if (null !== $request->file('event_attachment')) {
            $description = $request->input('event_attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('event_attachment'), 'event', $retreat->id, 'event_attachment', $description);
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
        if (! empty($retreat->calendar_id)) {
            //dd($retreat->calendar_id);
            $calendar_event = Event::find($retreat->calendar_id);
            /*
             * Initial work to manage attendees from Polanco
             * Need to clean up management of primary emails
             * Should this be limited to montserratretreat.org emails?
             * What about guest directors?
             */
            //$calendar_event->attendees = $retreat->retreat_attendees;
            if (! empty($calendar_event)) {
                $calendar_event->name = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
                $calendar_event->summary = $retreat->idnumber.'-'.$retreat->title.'-'.$retreat->retreat_team;
                $calendar_event->startDateTime = $retreat->start_date;
                $calendar_event->endDateTime = $retreat->end_date;
                $retreat_url = url('retreat/'.$retreat->id);
                $calendar_event->description = "<a href='".$retreat_url."'>".$retreat->idnumber.' - '.$retreat->title.'</a> : '.$retreat->description;
                //dd($calendar_event);
                $calendar_event->save();
            }
        }

        return Redirect::action('RetreatController@show',$id);
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
        // if there is a calendar id for the event then find the Google Calendar event, mark it as canceled and then remove it from the calendar (soft delete)
        if (! empty($retreat->calendar_id)) {
            $calendar_event = Event::findOrFail($retreat->calendar_id);
            if (! empty($calendar_event)) {
                $calendar_event->name = '[CANCELED] '.$retreat->title.' ('.$retreat->idnumber.')';
                $calendar_event->save();
                $calendar_event->delete();
            }
        }

        \App\Retreat::destroy($id);

        return Redirect::action('RetreatController@index');
    }

    public function assign_rooms($id)
    {
        $this->authorize('update-registration');
        //get this retreat's information
        $retreat = \App\Retreat::with('retreatmasters', 'assistant', 'innkeeper', 'captains')->findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->with('retreatant.parish')->orderBy('register_date', 'DESC')->get();
        $rooms = \App\Room::orderby('name')->pluck('name', 'id');
        $rooms->prepend('Unassigned', 0);

        return view('retreats.assign_rooms', compact('retreat', 'registrations', 'rooms'));
    }

    public function edit_payments($id)
    {
        $this->authorize('update-payment');
        //get this retreat's information
        $retreat = \App\Retreat::findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereCanceledAt(null)->with('retreatant.parish', 'donation')->orderBy('register_date', 'DESC')->get();
        $payment_description = config('polanco.payment_method');
        $donation_description = \App\DonationType::whereIsActive(1)->orderby('name')->pluck('name', 'id');
        $donation_description->prepend('Unassigned', 0);

        return view('retreats.payments.edit', compact('retreat', 'registrations', 'donation_description', 'payment_description'));
    }

    public function show_payments($id)
    {
        $this->authorize('show-payment');
        $retreat = \App\Retreat::findOrFail($id);
        $registrations = \App\Registration::where('event_id', '=', $id)->whereCanceledAt(null)->with('retreatant.parish', 'donation')->orderBy('register_date', 'DESC')->get();

        return view('retreats.payments.show', compact('retreat', 'registrations'));
    }

    public function checkout($id)
    {
        /* checkout all registrations for a retreat where the arrived_at is not NULL and the departed is NULL for a particular event */
        // TODO: consider also checking to see if the arrived_at time is empty and if it is put in the retreat start time
        $this->authorize('update-registration');
        $retreat = \App\Retreat::findOrFail($id); //verifies that it is a valid retreat id
        $registrations = \App\Registration::whereEventId($id)->whereCanceledAt(null)->whereDepartedAt(null)->whereNotNull('arrived_at')->get();
        foreach ($registrations as $registration) {
            $registration->departed_at = $registration->retreat_end_date;
            $registration->save();
        }

        return Redirect::action('RetreatController@show', $retreat->id);
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

        return Redirect::action('RetreatController@show', $retreat->id);
    }

    public function room_update(RoomUpdateRetreatRequest $request)
    {
        $this->authorize('update-registration');

        if (null !== $request->input('registrations')) {
            foreach ($request->input('registrations') as $key => $value) {
                $registration = \App\Registration::findOrFail($key);
                $registration->room_id = $value;
                $registration->save();
                //dd($registration,$value,$key);
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
    {
        $this->authorize('show-retreat');
        if (null !== config('settings.google_calendar_id')) {
            $calendar_events = \Spatie\GoogleCalendar\Event::get();
        } else {
            $calendar_events = collect([]);
        }

        return view('calendar.index', compact('calendar_events'));
    }

    public function event_room_list($event_id)
    {
        // get buildings for which there are assigned rooms
        // for each building initialize array of all rooms in that building
        // for each registration add contact sort_name to room
        // view room_lists
        // TODO: write unit tests for this method
        $this->authorize('show-registration');
        $event = \App\Retreat::findOrFail($event_id);
        $registrations = \App\Registration::whereEventId($event_id)->whereNull('canceled_at')->with('room')->get();
        $room_ids = \App\Registration::whereEventId($event_id)->whereNull('canceled_at')->pluck('room_id');
        $location_ids = \App\Room::whereIn('id', $room_ids)->pluck('location_id')->unique();
        $building_ids = \App\Location::whereIn('id', $location_ids)->pluck('id');
        $results = [];
        foreach ($building_ids as $building) {
            $building_rooms = \App\Room::whereLocationId($building)->with('location')->orderBy('name')->get();
            foreach ($building_rooms as $room) {
                $results[$room->location->name][$room->floor][$room->name] = '';
            }
        }

        foreach ($registrations as $registration) {
            if ($registration->room_id > 0) {
                // if the registered retreatant is not an individual person - for example a contract group organization then use the registration note for the name of the retreatant
                if ($registration->retreatant->contact_type == config('polanco.contact_type.individual')) {
                    $results[$registration->room->location->name][$registration->room->floor][$registration->room->name] = $registration->retreatant->sort_name;
                } else {
                    // if there is no note; default back to the sort_name of the contact
                    if (isset($registration->notes)) {
                        $results[$registration->room->location->name][$registration->room->floor][$registration->room->name] = $registration->notes;
                    } else {
                        $results[$registration->room->location->name][$registration->room->floor][$registration->room->name] = $registration->retreatant->sort_name;
                    }
                }
            }
        }

        return view('retreats.roomlist', compact('results', 'event'));
    }

    public function event_namebadges($event_id)
    {
        // for each registration add contact sort_name to namebadge
        // TODO: write unit tests for this method
        $this->authorize('show-registration');
        $event = \App\Retreat::findOrFail($event_id);
        $registrations = \App\Registration::whereEventId($event_id)->whereNull('canceled_at')->get();

        $results = [];
        foreach ($registrations as $registration) {
            // if the registered retreatant is not an individual person - for example a contract group organization then use the registration note for the name of the retreatant
            if ($registration->retreatant->contact_type == config('polanco.contact_type.individual')) {
                $results[$registration->id] = $registration->retreatant->sort_name;
                $registration->badgename = $registration->retreatant->sort_name;

            } else {
                // if there is no note; default back to the sort_name of the contact
                if (isset($registration->notes)) {
                    $results[$registration->id] = $registration->notes;
                    $registration->badgename = $registration->notes;
                } else {
                    $results[$registration->id] = $registration->retreatant->sort_name;
                    $registration->badgename = $registration->retreatant->sort_name;
                }
            }
        }
        asort($results);
        $cresults = collect($results);
        $registrations->sortBy('badgename')->all();

        return view('retreats.namebadges', compact('cresults', 'event'));
    }

    public function search()
    {
        $this->authorize('show-retreat');
        $event_types = \App\EventType::whereIsActive(true)->pluck('label', 'id');
        $event_types->prepend('N/A', 0);

        return view('retreats.search', compact('event_types'));
    }

    public function results(Request $request)
    {
        $this->authorize('show-retreat');
        // dd($request);
        if (! empty($request)) {
            $events = \App\Retreat::filtered($request)->orderBy('idnumber')->paginate(100);
            $events->appends($request->except('page'));
        }
        // dd($events);
        return view('retreats.results', compact('events'));
    }


}
