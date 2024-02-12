@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Activity</strong></h2>
        {{ html()->form('POST', url('activity'))->class('form-horizontal panel')->open() }}
        <span>
            <div class='row'>
                {{ html()->label('Date of activity:', 'activity_date_time')->class('col-md-3') }}
                {{ html()->text('activity_date_time', date('F j, Y g:i A', strtotime(\Carbon\Carbon::now())))->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Activity type:', 'activity_type_id')->class('col-md-3') }}
                {{ html()->select('activity_type_id', $activity_type)->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Contacted by:', 'staff_id')->class('col-md-3') }}
                @if (isset($defaults['user_id']))
                    {{ html()->select('staff_id', $staff, $defaults['user_id'])->class('col-md-3') }}
                @else
                    {{ html()->select('staff_id', $staff)->class('col-md-3') }}

                @endif

            </div>
            <div class='row'>
                {{ html()->label('Name of Contact:', 'person_id')->class('col-md-3') }}
                @if (isset($defaults['contact_id']))
                    {{ html()->select('person_id', $persons, $defaults['contact_id'])->class('col-md-3') }}
                @else
                    {{ html()->select('person_id', $persons)->class('col-md-3') }}
                @endif

            </div>
            <div class='row'>
                {{ html()->label('Subject:', 'subject')->class('col-md-3') }}
                {{ html()->text('subject')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Details:', 'details')->class('col-md-3') }}
                {{ html()->textarea('details')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Activity medium:', 'medium_id')->class('col-md-3') }}
                {{ html()->select('medium_id', $medium)->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Activity status:', 'status_id')->class('col-md-3') }}
                {{ html()->select('status_id', $status)->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Duration (minutes): ', 'duration')->class('col-md-3') }}
                {{ html()->text('duration')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Activity priority:', 'priority_id')->class('col-md-3') }}
                {{ html()->select('priority_id', array_map('ucfirst', array_flip(config('polanco.priority'))))->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Location: ', 'location')->class('col-md-3') }}
                {{ html()->text('location')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Created by:', 'created_by')->class('col-md-3') }}
                @if (isset($defaults['user_id']))
                    {{ html()->select('created_by', $staff, $defaults['user_id'])->class('col-md-3') }}
                @else
                    {{ html()->select('created_by', $staff)->class('col-md-3') }}

                @endif

            </div>

        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add Activity')->class('btn btn-primary') }}
            </div>
                {{ html()->form()->close() }}
        </div>
        <div class="clearfix"> </div>
    </span>
    </div>
</section>
@stop
