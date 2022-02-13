<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupTouchpointRequest;
use App\Http\Requests\StoreRetreatTouchpointRequest;
use App\Http\Requests\StoreRetreatWaitlistTouchpointRequest;
use App\Http\Requests\StoreTouchpointRequest;
use App\Http\Requests\UpdateTouchpointRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TouchpointController extends Controller
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
        $this->authorize('show-touchpoint');

        $staff = \App\Models\Touchpoint::groupBy('staff_id')->select('staff_id')->with('staff')->get()->sortBy('staff.sort_name')->pluck('staff.sort_name', 'staff_id');
        $touchpoints = \App\Models\Touchpoint::orderBy('touched_at', 'desc')->with('person.prefix', 'person.suffix', 'staff.prefix', 'staff.suffix')->paginate(25, ['*'], 'touchpoints');

        return view('touchpoints.index', compact('touchpoints', 'staff'));
    }

    /**
     * Display a listing of touchpoints associated with a particular staff member
     *
     * @param  int  $staff_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index_type($staff_id = null)
    {
        $this->authorize('show-touchpoint');

        $staff = \App\Models\Touchpoint::groupBy('staff_id')->select('staff_id')->with('staff')->get()->sortBy('staff.sort_name')->pluck('staff.sort_name', 'staff_id');
        $touchpoints = \App\Models\Touchpoint::whereStaffId($staff_id)->orderBy('touched_at', 'desc')->with('person.prefix', 'person.suffix', 'staff.prefix', 'staff.suffix')->paginate(25, ['*'], 'touchpoints');

        return view('touchpoints.index', compact('touchpoints', 'staff'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-touchpoint');
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $persons = \App\Models\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        // TODO: review similar instances in other methods to make use of contact_email relationship in User model
        $current_user = $request->user();
        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
            if (! $staff->has($current_user->contact_id)) {
                $staff->prepend($current_user->contact_email->owner->sort_name, $current_user->contact_id);
            }
        }

        return view('touchpoints.create', compact('staff', 'persons', 'defaults'));
    }

    public function add_group(Request $request, $group_id = 0)
    {
        $this->authorize('create-touchpoint');
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        $groups = \App\Models\Group::orderBy('title')->pluck('title', 'id');
        $defaults['group_id'] = $group_id;
        // if a group_id is provided ensure that the group actually exists otherwise fail with 404
        if ($group_id > 0) {
            $group = \App\Models\Group::findOrFail($group_id);
        }
        $current_user = $request->user();
        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
            if (! $staff->has($current_user->contact_id)) {
                $staff->prepend($current_user->contact_email->owner->sort_name, $current_user->contact_id);
            }
        }

        return view('touchpoints.add_group', compact('staff', 'groups', 'defaults'));
    }

    public function add_retreat(Request $request, $event_id = 0)
    {
        $this->authorize('create-touchpoint');
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        $retreats = \App\Models\Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->orderBy('start_date', 'desc')->pluck('description', 'id');
        $retreats->prepend('Unassigned', 0);

        $retreat = \App\Models\Retreat::findOrFail($event_id);
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $participants = \App\Models\Registration::whereEventId($event_id)->whereCanceledAt(null)->get();
        $current_user = $request->user();

        $defaults['event_id'] = $event_id;
        $defaults['event_description'] = $retreat->idnumber.'-'.$retreat->title.' ('.$retreat->start_date.')';
        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
            if (! $staff->has($current_user->contact_id)) {
                $staff->prepend($current_user->contact_email->owner->sort_name, $current_user->contact_id);
            }
        }

        return view('touchpoints.add_retreat', compact('staff', 'retreat', 'retreats', 'participants', 'defaults'));
    }

    public function add_retreat_waitlist(Request $request, $event_id = 0)
    {
        $this->authorize('create-touchpoint');
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        $retreats = \App\Models\Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->orderBy('start_date', 'desc')->pluck('description', 'id');
        $retreats->prepend('Unassigned', 0);

        $retreat = \App\Models\Retreat::findOrFail($event_id);
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $participants = \App\Models\Registration::whereEventId($event_id)->whereStatusId(config('polanco.registration_status_id.waitlist'))->whereCanceledAt(null)->get();
        $current_user = $request->user();

        $defaults['event_id'] = $event_id;
        $defaults['event_description'] = $retreat->idnumber.'-'.$retreat->title.' ('.$retreat->start_date.')';
        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
            if (! $staff->has($current_user->contact_id)) {
                $staff->prepend($current_user->contact_email->owner->sort_name, $current_user->contact_id);
            }
        }

        return view('touchpoints.add_retreat_waitlist', compact('staff', 'retreat', 'retreats', 'participants', 'defaults'));
    }

    public function add(Request $request, $id)
    {
        $this->authorize('create-touchpoint');

        //lookup the contact type of the touchpoint being added and show similar ones in drop down (persons, parishes, etc.)
        $contact = \App\Models\Contact::findOrFail($id);
        if (isset($contact->subcontact_type)) {
            $persons = \App\Models\Contact::whereSubcontactType($contact->subcontact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        } else {
            $persons = \App\Models\Contact::whereContactType($contact->contact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');

        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box

        $current_user = $request->user();

        $defaults['contact_id'] = $id;
        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
            if (! $staff->has($current_user->contact_id)) {
                $staff->prepend($current_user->contact_email->owner->sort_name, $current_user->contact_id);
            }
        }

        return view('touchpoints.create', compact('staff', 'persons', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTouchpointRequest $request)
    {
        $this->authorize('create-touchpoint');

        $touchpoint = new \App\Models\Touchpoint;
        $touchpoint->person_id = $request->input('person_id');
        $touchpoint->staff_id = $request->input('staff_id');
        $touchpoint->touched_at = $request->input('touched_at');
        $touchpoint->type = $request->input('type');
        $touchpoint->notes = $request->input('notes');
        $touchpoint->save();

        flash('Touchpoint ID#: <a href="'.url('/touchpoint/'.$touchpoint->id).'">'.$touchpoint->id.'</a> added')->success();

        return Redirect::action('TouchpointController@index');
    }

    public function store_group(StoreGroupTouchpointRequest $request)
    {
        $this->authorize('create-touchpoint');
        $group_id = $request->input('group_id');
        $group = \App\Models\Group::findOrFail($group_id);
        $group_members = \App\Models\GroupContact::whereGroupId($group_id)->whereStatus('Added')->get();
        foreach ($group_members as $group_member) {
            $touchpoint = new \App\Models\Touchpoint;
            $touchpoint->person_id = $group_member->contact_id;
            $touchpoint->staff_id = $request->input('staff_id');
            $touchpoint->touched_at = $request->input('touched_at');
            $touchpoint->type = $request->input('type');
            $touchpoint->notes = $request->input('notes');
            $touchpoint->save();
        }

        flash('Touchpoint added for members of group: <a href="'.url('/group/'.$group_id).'">'.$group->name.'</a>')->success();

        return Redirect::action('GroupController@show', $group_id);
    }

    public function store_retreat(StoreRetreatTouchpointRequest $request)
    {
        $this->authorize('create-touchpoint');
        $event_id = $request->input('event_id');
        $event = \App\Models\Retreat::findOrFail($event_id);
        $participants = \App\Models\Registration::whereStatusId(config('polanco.registration_status_id.registered'))->whereEventId($event_id)->whereRoleId(config('polanco.participant_role_id.retreatant'))->whereNull('canceled_at')->get();
        foreach ($participants as $participant) {
            $touchpoint = new \App\Models\Touchpoint;
            $touchpoint->person_id = $participant->contact_id;
            $touchpoint->staff_id = $request->input('staff_id');
            $touchpoint->touched_at = $request->input('touched_at');
            $touchpoint->type = $request->input('type');
            $touchpoint->notes = $request->input('notes');
            $touchpoint->save();
        }

        flash('Touchpoint added for registered event participants: <a href="'.url('/retreat/'.$event_id).'">'.$event->title.'</a>')->success();

        return Redirect::action('RetreatController@show', $event_id);
    }

    public function store_retreat_waitlist(StoreRetreatWaitlistTouchpointRequest $request)
    {
        $this->authorize('create-touchpoint');
        $event_id = $request->input('event_id');
        $event = \App\Models\Retreat::findOrFail($event_id);
        $participants = \App\Models\Registration::whereStatusId(config('polanco.registration_status_id.waitlist'))->whereEventId($event_id)->whereRoleId(config('polanco.participant_role_id.retreatant'))->whereNull('canceled_at')->get();
        foreach ($participants as $participant) {
            $touchpoint = new \App\Models\Touchpoint;
            $touchpoint->person_id = $participant->contact_id;
            $touchpoint->staff_id = $request->input('staff_id');
            $touchpoint->touched_at = $request->input('touched_at');
            $touchpoint->type = $request->input('type');
            $touchpoint->notes = $request->input('notes');
            $touchpoint->save();
        }

        flash('Touchpoint added for waitlisted event participants: <a href="'.url('/retreat/'.$event_id).'">'.$event->title.'</a>')->success();

        return Redirect::action('RetreatController@show', $event_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-touchpoint');
        $touchpoint = \App\Models\Touchpoint::with('staff', 'person')->findOrFail($id);

        return view('touchpoints.show', compact('touchpoint')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-touchpoint');
        $touchpoint = \App\Models\Touchpoint::with('staff', 'person')->findOrFail($id);

        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id')->toArray();
        /* ensure that a staff member has not been removed */
        if (isset($touchpoint->staff->id)) {
            if (! Arr::has($staff, $touchpoint->staff->id)) {
                $staff[$touchpoint->staff->id] = $touchpoint->staff->sort_name.' (former)';
                asort($staff);
                // dd($touchpoint->staff->sort_name.' is not currently a staff member: '.$touchpoint->staff->id, $staff);
            }
        }

        //consider renaming touchpoint table's person_id field to contact_id
        $contact = \App\Models\Contact::findOrFail($touchpoint->person_id);
        if (isset($contact->subcontact_type)) {
            $persons = \App\Models\Contact::whereSubcontactType($contact->subcontact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        } else {
            $persons = \App\Models\Contact::whereContactType($contact->contact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        //$persons = \App\Models\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name')->pluck('sort_name','id');
// check contact type and if parish get list of parishes if individual get list of persons
        return view('touchpoints.edit', compact('touchpoint', 'staff', 'persons')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTouchpointRequest $request, $id)
    {
        $this->authorize('update-touchpoint');
        $touchpoint = \App\Models\Touchpoint::findOrFail($request->input('id'));
        $touchpoint->person_id = $request->input('person_id');
        $touchpoint->staff_id = $request->input('staff_id');
        $touchpoint->touched_at = $request->input('touched_at');
        $touchpoint->type = $request->input('type');
        $touchpoint->notes = $request->input('notes');
        $touchpoint->save();

        flash('Touchpoint ID#: <a href="'.url('/touchpoint/'.$touchpoint->id).'">'.$touchpoint->id.'</a> updated')->success();

        return Redirect::action('TouchpointController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-touchpoint');

        \App\Models\Touchpoint::destroy($id);

        flash('Touchpoint ID#: '.$id.' deleted')->warning()->important();

        return Redirect::action('TouchpointController@index');
    }
}
