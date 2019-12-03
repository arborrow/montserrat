<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
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
        $this->authorize('show-activity');
        $activities = \App\Activity::orderBy('activity_date_time', 'desc')->paginate(100);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-activity');
        $staff = \App\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $persons = \App\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $current_user = Auth::user();
        $user_email = \App\Email::whereEmail($current_user->email)->first();
        if (empty($user_email->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $user_email->contact_id;
        }
        $status = \App\ActivityStatus::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $status->prepend('N/A', 0);
        $activity_type = \App\ActivityType::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $activity_type->prepend('N/A', 0);
        $medium = array_flip(config('polanco.medium'));
        $medium[0] = 'Unspecified';
        $medium = array_map('ucfirst', $medium);
        //$medium->prepend('N/A', 0);

        return view('activities.create', compact('staff', 'persons', 'defaults', 'status', 'activity_type', 'medium'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-activity');
        $this->validate($request, [
            'touched_at' => 'required|date',
            'person_id' => 'required|integer|min:0',
            'staff_id' => 'required|integer|min:0',
            'activity_type_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:0',
            'priority_id' => 'required|integer|min:0',
            'medium_id' => 'required|integer|min:1',
            'duration' => 'integer|min:0',
        ]);
        $activity_type = \App\ActivityType::findOrFail($request->input('activity_type_id'));
        $activity = new \App\Activity;
        $activity->activity_type_id = $request->input('activity_type_id');
        $activity->subject = $activity_type->label;
        $activity->activity_date_time = Carbon::parse($request->input('touched_at'));
        $activity->duration = $request->input('duration');
        $activity->location = $request->input('location');
        // $activity->phone_number = $request->input('phone_number');
        $activity->details = $request->input('details');
        $activity->status_id = $request->input('status_id');
        $activity->priority_id = $request->input('priority_id');
        $activity->medium_id = $request->input('medium_id');
        $activity->save();

        $activity_target = new \App\ActivityContact;
        $activity_target->activity_id = $activity->id;
        $activity_target->contact_id = $request->input('person_id');
        $activity_target->record_type_id = config('polanco.activity_contacts_type.target');
        $activity_target->save();

        $activity_source = new \App\ActivityContact;
        $activity_source->activity_id = $activity->id;
        $activity_source->contact_id = $request->input('staff_id');
        $activity_source->record_type_id = config('polanco.activity_contacts_type.creator');
        $activity_source->save();

        $activity_assignee = new \App\ActivityContact;
        $activity_assignee->activity_id = $activity->id;
        $activity_assignee->contact_id = $request->input('staff_id');
        $activity_assignee->record_type_id = config('polanco.activity_contacts_type.assignee');
        $activity_assignee->save();

        return Redirect::action('ActivityController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-activity');
        $activity = \App\Activity::with('assignees', 'creators', 'targets')->findOrFail($id);

        return view('activities.show', compact('activity')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-activity');
        $activity = \App\Activity::findOrFail($id);
        $target = $activity->targets->first();
        $assignee = $activity->assignees->first();
        $creator = $activity->creators->first();

        $staff = \App\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');

        $activity_type = \App\ActivityType::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $activity_type->prepend('N/A', 0);

        $status = \App\ActivityStatus::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $status->prepend('N/A', 0);

        $medium = array_flip(config('polanco.medium'));
        $medium[0] = 'Unspecified';
        $medium = array_map('ucfirst', $medium);

        $contact = \App\Contact::findOrFail($target->contact_id);
        if (isset($contact->subcontact_type)) {
            $persons = \App\Contact::whereSubcontactType($contact->subcontact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        } else {
            $persons = \App\Contact::whereContactType($contact->contact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        }

        return view('activities.edit', compact('activity', 'staff', 'persons', 'target', 'assignee', 'creator', 'activity_type', 'status', 'medium'));
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
        $this->authorize('update-activity');
        $this->validate($request, [
            'touched_at' => 'required|date',
            'target_id' => 'required|integer|min:0',
            'assignee_id' => 'required|integer|min:0',
            'creator_id' => 'required|integer|min:0',
            'activity_type_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:0',
            'priority_id' => 'required|integer|min:0',
            'medium_id' => 'required|integer|min:1',
            'duration' => 'integer|min:0',
        ]);
        $activity_type = \App\ActivityType::findOrFail($request->input('activity_type_id'));
        $activity = \App\Activity::findOrFail($id);

        $activity->activity_date_time = Carbon::parse($request->input('touched_at'));
        $activity->activity_type_id = $request->input('activity_type_id');
        $activity->subject = $request->input('subject');
        $activity->details = $request->input('details');
        $activity->medium_id = $request->input('medium_id');
        $activity->status_id = $request->input('status_id');
        $activity->duration = $request->input('duration');
        $activity->priority_id = $request->input('priority_id');
        $activity->location = $request->input('location');
        // $activity->phone_number = $request->input('phone_number');
        $activity->save();

        $activity_target = \App\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.target'))->firstOrFail();
        $activity_target->contact_id = $request->input('target_id');
        $activity_target->save();

        $activity_source = \App\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.creator'))->firstOrFail();
        $activity_source->contact_id = $request->input('assignee_id');
        $activity_source->save();

        $activity_assignee = \App\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.assignee'))->firstOrFail();
        $activity_assignee->contact_id = $request->input('creator_id');
        $activity_assignee->save();

        return Redirect::action('ActivityController@show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete activity contacts and then the activity (could be handled in model with cascading deletes)

        $this->authorize('delete-activity');
        \App\ActivityContact::whereActivityId($id)->delete();
        \App\Activity::destroy($id);

        return Redirect::action('ActivityController@index');
    }
}
