@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Activity</strong></h2>
        {!! Form::open(['url' => 'activity', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('touched_at', 'Date of activity:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('touched_at',date('F j, Y g:i A', strtotime(\Carbon\Carbon::now())) , ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('activity_type_id', 'Activity type:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('activity_type_id', $activity_type, NULL, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('staff_id', 'Contacted by:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['user_id']))
                    {!! Form::select('staff_id', $staff, $defaults['user_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('staff_id', $staff, NULL, ['class' => 'col-md-3']) !!}
                
                @endif
                
            </div>
            <div class='row'>
                {!! Form::label('person_id', 'Name of Contact:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['contact_id']))
                    {!! Form::select('person_id', $persons, $defaults['contact_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('person_id', $persons, NULL, ['class' => 'col-md-3']) !!}
                @endif
                        
            </div>
            <div class='row'>
                {!! Form::label('subject', 'Subject:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('subject',null, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('details', 'Details:', ['class' => 'col-md-3'])  !!}
                {!! Form::textarea('details', NULL, ['class' => 'col-md-3']) !!}                   
            </div>
            <div class='row'>
                {!! Form::label('medium_id', 'Activity medium:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('medium_id', $medium, NULL, ['class' => 'col-md-3']) !!}
            </div>           
            <div class='row'>
                {!! Form::label('status_id', 'Activity status:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('status_id', $status, NULL, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('duration', 'Duration (minutes): ', ['class' => 'col-md-3'])  !!}
                {!! Form::text('duration', null, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('priority_id', 'Activity priority:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('priority_id', array_map('ucfirst',array_flip(config('polanco.priority'))), NULL, ['class' => 'col-md-3']) !!}
            </div>           
            <div class='row'>
                {!! Form::label('location', 'Location: ', ['class' => 'col-md-3'])  !!}
                {!! Form::text('location', null, ['class' => 'col-md-3']) !!}
            </div>  
            <div class='row'>
                {!! Form::label('created_by', 'Created by:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['user_id']))
                    {!! Form::select('created_by', $staff, $defaults['user_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('created_by', $staff, NULL, ['class' => 'col-md-3']) !!}
                
                @endif
                
            </div>
            
        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Activity', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
    </span>
    </div>
</section>
@stop