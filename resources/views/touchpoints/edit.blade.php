@extends('template')
@section('content')


<div class="jumbotron text-left">
    <span><h2><strong>Edit Touchpoint:</strong></h2></span>

    {{ html()->form('PUT', route('touchpoint.update', [$touchpoint->id]))->open() }}
    {{ html()->hidden('id', $touchpoint->id) }}

        <span>
            <h2>Touchpoint details</h2>
                <div class="form-group">
                    <div class='row'>
                        {{ html()->label('Date of contact:', 'touched_at')->class('col-md-3') }}
                        {{ html()->datetime('touched_at', $touchpoint->touched_at)->class('col-md-3 form-control flatpickr-date-time') }}

                    </div>
                    <div class='row'>
                        {{ html()->label('Name of Contact:', 'person_id')->class('col-md-3') }}
                        {{ html()->select('person_id', $persons, $touchpoint->person_id)->class('col-md-3') }}
                    </div>
                    <div class='row'>
                        {{ html()->label('Contacted by:', 'staff_id')->class('col-md-3') }}
                        {{ html()->select('staff_id', $staff, $touchpoint->staff_id)->class('col-md-3') }}
                    </div>

                    <div class='row'>
                        {{ html()->label('Type of Contact:', 'type')->class('col-md-3') }}
                            {{ html()->select('type', config('polanco.touchpoint_source'), $touchpoint->type)->class('col-md-3') }}

                    </div>
                    <div class='row'>
                        {{ html()->label('Notes:', 'notes')->class('col-md-3') }}
                        {{ html()->textarea('notes', $touchpoint->notes)->class('col-md-3') }}
                    </div>
                </div>
            </span>


    <div class="form-group">
        {{ html()->input('image', 'btnSave')->class('btn btn-primary')->attribute('src', asset('images/save.png')) }}
    </div>
    {{ html()->form()->close() }}
</div>
@stop
