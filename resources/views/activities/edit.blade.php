@extends('template')
@section('content')


<div class="jumbotron text-left">
    <span><h2><strong>Edit Activity:</strong></h2></span>

    {{ html()->form('PUT', route('activity.update', [$activity->id]))->open() }}
    {{ html()->hidden('id', $activity->id) }}

        <span>
            <h2>Activity details</h2>
                <div class="form-group">
                    <div class='row'>
                        {{ html()->label('Date of contact:', 'activity_date_time')->class('col-md-3') }}
                        {{ html()->text('activity_date_time', date('F j, Y g:i A', strtotime($activity->activity_date_time)))->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Activity type:', 'activity_type_id')->class('col-md-3') }}
                        {{ html()->select('activity_type_id', $activity_type, $activity->activity_type_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Contacted by:', 'assignee_id')->class('col-md-3') }}
                        {{ html()->select('assignee_id', $staff, $assignee->contact_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Name of Contact:', 'target_id')->class('col-md-3') }}
                        {{ html()->select('target_id', $persons, $target->contact_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Subject:', 'subject')->class('col-md-3') }}
                        {{ html()->text('subject', $activity->subject)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Details:', 'details')->class('col-md-3') }}
                        {{ html()->textarea('details', $activity->details)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Activity medium:', 'medium_id')->class('col-md-3') }}
                        {{ html()->select('medium_id', $medium, $activity->medium_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Activity status:', 'status_id')->class('col-md-3') }}
                        {{ html()->select('status_id', $status, $activity->status_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Duration (minutes): ', 'duration')->class('col-md-3') }}
                        {{ html()->text('duration', $activity->duration)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Activity priority:', 'priority_id')->class('col-md-3') }}
                        {{ html()->select('priority_id', array_map('ucfirst', array_flip(config('polanco.priority'))), $activity->priority_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Location: ', 'location')->class('col-md-3') }}
                        {{ html()->text('location', $activity->location)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Created by:', 'creator_id')->class('col-md-3') }}
                        @if (isset($creator->contact_id))
                            {{ html()->select('creator_id', $staff, $creator->contact_id)->class('col-md-3') }}
                        @else
                            {{ html()->select('creator_id', $staff)->class('col-md-3') }}

                        @endif

                    </div>


                </div>
            </span>


    <div class="form-group">
        {{ html()->input('image', 'btnSave')->class('btn btn-primary')->attribute('src', asset('images/save.png')) }}
    </div>
    {{ html()->form()->close() }}
</div>
@stop
