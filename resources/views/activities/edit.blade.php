@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Activity:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['activity.update', $activity->id]]) !!}
    {!! Form::hidden('id', $activity->id) !!}
    
        <span>
            <h2>Activity details</h2>
                <div class="form-group">
                    <div class='row'>
                        {!! Form::label('touched_at', 'Date of contact:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('touched_at', date('F j, Y g:i A', strtotime($activity->activity_date_time)), ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('activity_type_id', 'Activity type:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('activity_type_id', $activity_type, $activity->activity_type_id, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('assignee_id', 'Contacted by:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('assignee_id', $staff, $assignee->contact_id, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('target_id', 'Name of Contact:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('target_id', $persons, $target->contact_id, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('subject', 'Subject:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('subject',$activity->subject, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('details', 'Details:', ['class' => 'col-md-3'])  !!}
                        {!! Form::textarea('details', $activity->details, ['class' => 'col-md-3']) !!}                   
                    </div>
                    <div class='row'>
                        {!! Form::label('medium_id', 'Activity medium:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('medium_id', $medium, $activity->medium_id, ['class' => 'col-md-3']) !!}
                    </div>           
                    <div class='row'>
                        {!! Form::label('status_id', 'Activity status:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('status_id', $status, $activity->status_id, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('duration', 'Duration (minutes): ', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('duration', $activity->duration, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('priority_id', 'Activity priority:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('priority_id', array_map('ucfirst',array_flip(config('polanco.priority'))), $activity->priority_id, ['class' => 'col-md-3']) !!}
                    </div>           
                    <div class='row'>
                        {!! Form::label('location', 'Location: ', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('location', $activity->location, ['class' => 'col-md-3']) !!}
                    </div>  
                    <div class='row'>
                        {!! Form::label('creator_id', 'Created by:', ['class' => 'col-md-3'])  !!}
                        @if (isset($creator->contact_id))
                            {!! Form::select('creator_id', $staff, $creator->contact_id, ['class' => 'col-md-3']) !!}
                        @else
                            {!! Form::select('creator_id', $staff, NULL, ['class' => 'col-md-3']) !!}

                        @endif

                    </div>

                         
                </div>
            </span>
                

    <div class="form-group">
        {!! Form::image('/images/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop