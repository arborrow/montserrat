<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
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
        $activities = \App\Models\Activity::orderBy('activity_date_time', 'desc')->paginate(25, ['*'], 'activities');

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-activity');
        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $persons = \App\Models\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $current_user = $request->user();

        if (empty($current_user->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $current_user->contact_id;
        }
        $status = \App\Models\ActivityStatus::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $status->prepend('N/A', 0);
        $activity_type = \App\Models\ActivityType::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
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
    public function store(StoreActivityRequest $request)
    {
        $this->authorize('create-activity');
        $activity_type = \App\Models\ActivityType::findOrFail($request->input('activity_type_id'));
        $activity = new \App\Models\Activity;
        $activity->activity_type_id = $request->input('activity_type_id');
        $activity->subject = $activity_type->label;
        $activity->activity_date_time = $request->input('activity_date_time');
        $activity->duration = $request->input('duration');
        $activity->location = $request->input('location');
        // $activity->phone_number = $request->input('phone_number');
        $activity->details = $request->input('details');
        $activity->status_id = $request->input('status_id');
        $activity->priority_id = $request->input('priority_id');
        $activity->medium_id = $request->input('medium_id');
        $activity->save();

        $activity_target = new \App\Models\ActivityContact;
        $activity_target->activity_id = $activity->id;
        $activity_target->contact_id = $request->input('person_id');
        $activity_target->record_type_id = config('polanco.activity_contacts_type.target');
        $activity_target->save();

        $activity_source = new \App\Models\ActivityContact;
        $activity_source->activity_id = $activity->id;
        $activity_source->contact_id = $request->input('staff_id');
        $activity_source->record_type_id = config('polanco.activity_contacts_type.creator');
        $activity_source->save();

        $activity_assignee = new \App\Models\ActivityContact;
        $activity_assignee->activity_id = $activity->id;
        $activity_assignee->contact_id = $request->input('staff_id');
        $activity_assignee->record_type_id = config('polanco.activity_contacts_type.assignee');
        $activity_assignee->save();

        return Redirect::action([\App\Http\Controllers\ActivityController::class, 'index']);
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
        $activity = \App\Models\Activity::with('assignees', 'creators', 'targets')->findOrFail($id);

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
        $activity = \App\Models\Activity::findOrFail($id);
        $target = $activity->targets->first();
        $assignee = $activity->assignees->first();
        $creator = $activity->creators->first();

        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id');

        $activity_type = \App\Models\ActivityType::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $activity_type->prepend('N/A', 0);

        $status = \App\Models\ActivityStatus::whereIsActive(1)->orderBy('label')->pluck('label', 'id');
        $status->prepend('N/A', 0);

        $medium = array_flip(config('polanco.medium'));
        $medium[0] = 'Unspecified';
        $medium = array_map('ucfirst', $medium);

        $contact = \App\Models\Contact::findOrFail($target->contact_id);
        if (isset($contact->subcontact_type)) {
            $persons = \App\Models\Contact::whereSubcontactType($contact->subcontact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
        } else {
            $persons = \App\Models\Contact::whereContactType($contact->contact_type)->orderBy('sort_name')->pluck('sort_name', 'id');
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
    public function update(UpdateActivityRequest $request, $id)
    {
        $this->authorize('update-activity');
        $activity_type = \App\Models\ActivityType::findOrFail($request->input('activity_type_id'));
        $activity = \App\Models\Activity::findOrFail($id);

        $activity->activity_date_time = $request->input('activity_date_time');
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

        $activity_target = \App\Models\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.target'))->firstOrFail();
        $activity_target->contact_id = $request->input('target_id');
        $activity_target->save();

        $activity_source = \App\Models\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.creator'))->firstOrFail();
        $activity_source->contact_id = $request->input('assignee_id');
        $activity_source->save();

        $activity_assignee = \App\Models\ActivityContact::whereActivityId($id)->whereRecordTypeId(config('polanco.activity_contacts_type.assignee'))->firstOrFail();
        $activity_assignee->contact_id = $request->input('creator_id');
        $activity_assignee->save();

        return Redirect::action([\App\Http\Controllers\ActivityController::class, 'show'], $id);
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
        \App\Models\ActivityContact::whereActivityId($id)->delete();
        \App\Models\Activity::destroy($id);

        return Redirect::action([\App\Http\Controllers\ActivityController::class, 'index']);
    }
}
