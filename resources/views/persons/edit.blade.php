@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Person: 
        {{ $person->prefix_name }} 
        {{ isset($person->display_name) ? $person->display_name : null }} 
        {{ $person->suffix_name }}
        {{ (!empty($person->nick_name)) ? "(&quot;$person->nick_name&quot;)" : null }}
    </strong></h2></span>

    <span class="back">
        @if ($person->is_assistant) <span class="back"><a href={{ action('PersonsController@assistants') }}>{!! Html::image('img/assistant.png', 'Assistants Index',array('title'=>"Assistants Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_bishop) <span class="back"><a href={{ action('PersonsController@bishops') }}>{!! Html::image('img/bishop.png', 'Bishop Index',array('title'=>"Bishop Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_board) <span class="back"><a href={{ action('PersonsController@boardmembers') }}>{!! Html::image('img/board.png', 'Board Members Index',array('title'=>"Board Members Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_captain) <span class="back"><a href={{ action('PersonsController@captains') }}>{!! Html::image('img/captain.png', 'Captains Index',array('title'=>"Captains Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_catholic) <span class="back"><a href={{ action('PersonsController@catholics') }}>{!! Html::image('img/catholic.png', 'Catholics Index',array('title'=>"Catholics Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_director) <span class="back"><a href={{ action('PersonsController@directors') }}>{!! Html::image('img/director.png', 'Directors Index',array('title'=>"Directors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_donor) <span class="back"><a href={{ action('PersonsController@donors') }}>{!! Html::image('img/donor.png', 'Donor Index',array('title'=>"Donor Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_innkeeper) <span class="back"><a href={{ action('PersonsController@innkeepers') }}>{!! Html::image('img/innkeeper.png', 'Innkeepers Index',array('title'=>"Innkeepers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_pastor) <span class="back"><a href={{ action('PersonsController@pastors') }}>{!! Html::image('img/pastor.png', 'Pastors Index',array('title'=>"Pastors Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_retreatant) <span class="back"><a href={{ action('PersonsController@retreatants') }}>{!! Html::image('img/retreatant.png', 'Retreatants Index',array('title'=>"Retreatants Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_staff) <span class="back"><a href={{ action('PersonsController@employees') }}>{!! Html::image('img/employee.png', 'Employees Index',array('title'=>"Employees Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
        @if ($person->is_volunteer) <span class="back"><a href={{ action('PersonsController@volunteers') }}>{!! Html::image('img/volunteer.png', 'Volunteers Index',array('title'=>"Volunteers Index",'class' => 'btn btn-primary')) !!}</a></span> @endIf
    </span>                

    
    {!! Form::open(['method' => 'PUT', 'route' => ['person.update', $person->id]]) !!}
    {!! Form::hidden('id', $person->id) !!}
    
    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Name</h2>
                <div class="form-group">
                    {!! Form::label('prefix_id', 'Title:', ['class' => 'col-md-1'])  !!}
                    {!! Form::select('prefix_id', $prefixes, $person->prefix_id, ['class' => 'col-md-2']) !!}
               <div class="clearfix"> </div>
                      
                    {!! Form::label('first_name', 'First:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('first_name', $person->first_name, ['class' => 'col-md-2']) !!}
                    {!! Form::label('middle_name', 'Middle:', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('middle_name', $person->middle_name, ['class' => 'col-md-2']) !!}
                    {!! Form::label('last_name', 'Last:', ['class' => 'col-md-1'])  !!}
                    {!! Form::text('last_name', $person->last_name, ['class' => 'col-md-2']) !!}
                <div class="clearfix"> </div>
                    {!! Form::label('suffix_id', 'Suffix:', ['class' => 'col-md-1'])  !!}
                    {!! Form::select('suffix_id', $suffixes, $person->suffix_id, ['class' => 'col-md-2']) !!}
                        
                    {!! Form::label('nick_name', 'Nickname: ', ['class' => 'col-md-2'])  !!}
                    {!! Form::text('nick_name', $person->nick_name, ['class' => 'col-md-3']) !!}
                <div class="clearfix"> </div>
                    {!! Form::label('display_name', 'Display name: ', ['class' => 'col-md-3'])  !!}
                    {!! Form::text('display_name', $person->display_name, ['class' => 'col-md-3']) !!}
                    {!! Form::label('sort_name', 'Sort name: ', ['class' => 'col-md-3'])  !!}
                    {!! Form::text('sort_name', $person->sort_name, ['class' => 'col-md-3']) !!}
 
                </div>
                <div class="clearfix"> </div>
                    {!! Form::label('contact_type', 'Contact type: ', ['class' => 'col-md-3'])  !!}
                    {!! Form::select('contact_type', $contact_types, $person->contact_type, ['class' => 'col-md-2']) !!}
                    
                    {!! Form::label('subcontact_type', 'Subcontact type: ', ['class' => 'col-md-3'])  !!}
                    {!! Form::select('subcontact_type', $subcontact_types, $person->subcontact_type, ['class' => 'col-md-2']) !!}
                    
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>  

    <div class='row'>
        <div class='col-md-8'>
            <span>
                    <h2>Emergency Contact Information</h2>
                    <div class="form-group">
                        
                        {!! Form::label('emergency_contact_name', 'Name: ', ['class' => 'col-md-1'])  !!}
                        @if (isset($person->emergency_contact->name))
                            {!! Form::text('emergency_contact_name', $person->emergency_contact->name, ['class' => 'col-md-2']) !!}
                        @else
                           {!! Form::text('emergency_contact_name', null, ['class' => 'col-md-2']) !!}
                        @endif
                        
                        {!! Form::label('emergency_contact_relationship', 'Relationship: ', ['class' => 'col-md-2'])  !!}
                        @if (isset($person->emergency_contact->relationship))
                            {!! Form::text('emergency_contact_relationship', $person->emergency_contact->relationship, ['class' => 'col-md-2']) !!}
                        @else
                           {!! Form::text('emergency_contact_relationship', null, ['class' => 'col-md-2']) !!}
                        @endif
                        
                        <div class="clearfix"> </div>
                        {!! Form::label('emergency_contact_phone', 'Phone: ', ['class' => 'col-md-1'])  !!}
                        @if (isset($person->emergency_contact->phone))
                            {!! Form::text('emergency_contact_phone', $person->emergency_contact->phone, ['class' => 'col-md-2']) !!}
                        @else
                           {!! Form::text('emergency_contact_phone', null, ['class' => 'col-md-2']) !!}
                        @endif
                        
                        {!! Form::label('emergency_contact_phone_alternate', 'Alt. Phone: ', ['class' => 'col-md-2'])  !!}
                        @if (isset($person->emergency_contact->phone_alternate))
                            {!! Form::text('emergency_contact_phone_alternate', $person->emergency_contact->phone_alternate, ['class' => 'col-md-2']) !!}
                        @else
                           {!! Form::text('emergency_contact_phone_alternate', null, ['class' => 'col-md-2']) !!}
                        @endif
                    </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>

    <div class='row'>
        <div class='col-md-8'>
            <span>
  @include('persons.update.addresses')
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>

    <div class='row'>
        <div class='col-md-8'>
            <span>
                @include('persons.update.phones')
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class='row'>
        <div class='col-md-8'>
            <span>
            @include('persons.update.emails')
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class='row'>
        <div class='col-md-8'>
            <span>
            @include('persons.update.urls')
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    <div class='row'>
        <div class='col-md-8'>
            <span>
                <h2>Demographics</h2>
                    <div class="form-group">
                        {!! Form::label('gender_id', 'Gender:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('gender_id', $genders, $person->gender_id, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('birth_date', 'Birth Date:', ['class' => 'col-md-2']) !!}
                        {!! Form::text('birth_date', $person->birth_date, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        <div class="clearfix"> </div>

                        
                    </div>
                    <div class="form-group">
                        {!! Form::label('religion_id', 'Religion:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('religion_id', $religions, $person->religion_id, ['class' => 'col-md-2']) !!} 
                        <div class="clearfix"> </div>
                        {!! Form::label('occupation_id', 'Occupation:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('occupation_id', $occupations, $person->occupation_id, ['class' => 'col-md-3']) !!} 
                        <div class="clearfix"> </div>
                        
                        {!! Form::label('parish_id', 'Parish:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('parish_id', $parish_list, $person->parish_id, ['class' => 'col-md-8']) !!} 
                    <div class="clearfix"> </div>
                        
                    </div>
                    <div class="form-group">                        
                        {!! Form::label('ethnicity_id', 'Ethnicity:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('ethnicity_id', $ethnicities, $person->ethnicity_id, ['class' => 'col-md-2']) !!}
                        <div class="clearfix"> </div>
                        {!! Form::label('languages', 'Languages:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('languages[]', $languages, $person->languages->lists('id')->toArray(), ['class' => 'form-control col-md-2','multiple' => 'multiple','style'=>'width: auto; font-size: inherit;']) !!}
                
                        {!! Form::label('preferred_language_id', 'Preferred Language:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('preferred_language_id', $languages, $person->preferred_language_id, ['class' => 'col-md-3']) !!}
                    </div>
                <div class="clearfix"> </div>
                    <div class="form-group">                        
                        {!! Form::label('deceased_date', 'Deceased Date:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('deceased_date', $person->deceased_date, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
                        {!! Form::label('is_deceased', 'Is Deceased:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deceased', $person->is_deceased, false,['class' => 'col-md-1']) !!}
                        <div class="clearfix"> </div>
                    </div>
            </span>
        </div>
        <div class="clearfix"> </div>

    </div>
    <div class="clearfix"> </div>

    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>Health Notes</h2>
                <div class="form-group">
                    {!! Form::label('note_health', 'Health Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('note_health', $person->note_health, ['class' => 'col-md-3']) !!}
                    {!! Form::label('note_dietary', 'Dietary Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('note_dietary', $person->note_dietary, ['class' => 'col-md-3']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>


    <div class='row'>
        <div class='col-md-8'>
            <span>
            <h2>General Notes</h2>
                <div class="form-group">
                    {!! Form::label('note_contact', 'General Notes:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('note_contact', $person->note_contact, ['class' => 'col-md-3']) !!}
                    {!! Form::label('note_room_preference', 'Room Preference:', ['class' => 'col-md-2'])  !!}
                    {!! Form::textarea('note_room_preference', $person->note_room_preference, ['class' => 'col-md-3']) !!}
                </div>
            </span>
        </div>
    </div>
    <div class="clearfix"> </div>

    <div class='row'>
            <div class='col-md-8'>
                <span>
                    <h2>Groups and Relationships</h2>
                    <div class="form-group">
                        {!! Form::label('is_donor', 'Donor:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_donor', 1, $person->is_donor, ['class' => 'col-md-1']) !!}
                        {!! Form::label('is_retreatant', 'Retreatant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_retreatant', 1, $person->is_retreatant,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_captain', 'Captain:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_captain', 1, $person->is_captain,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_volunteer', 'Volunteer:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_volunteer', 1, $person->is_volunteer,['class' => 'col-md-1']) !!}
                    </div><div class="clearfix"> </div>
              
                    <div class="form-group">
                        {!! Form::label('is_bishop', 'Bishop:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_bishop', 1, $person->is_bishop,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_priest', 'Priest:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_priest', 1, $person->is_priest,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_deacon', 'Deacon:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_deacon', 1, $person->is_deacon,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_pastor', 'Pastor:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_pastor', 1, $person->is_pastor,['class' => 'col-md-1']) !!}
                    </div><div class="clearfix"> </div>
              
                    <div class="form-group">
                        {!! Form::label('is_jesuit', 'Jesuit:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_jesuit', 1, $person->is_jesuit,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_provincial', 'Provincial:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_provincial', 1, $person->is_provincial,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_superior', 'Superior:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_superior', 1, $person->is_superior,['class' => 'col-md-1']) !!}
                    </div><div class="clearfix"> </div>
              
                    <div class="form-group">
                        {!! Form::label('is_board', 'Board Member:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_board', 1, $person->is_board_member,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_formerboard', 'Former Board:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_formerboard', 1, false,['class' => 'col-md-1','disabled']) !!}
                    </div><div class="clearfix"> </div>
              
                    <div class="form-group">
                        {!! Form::label('is_staff', 'Staff:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_staff', 1, $person->is_staff,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_director', 'Retreat Director:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_director', 1, $person->is_retreat_director,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_innkeeper', 'Retreat Innkeeper:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_innkeeper', 1, $person->is_retreat_innkeeper,['class' => 'col-md-1']) !!}
                        {!! Form::label('is_assistant', 'Retreat Assistant:', ['class' => 'col-md-2'])  !!}
                        {!! Form::checkbox('is_assistant', 1, $person->is_retreat_assistant,['class' => 'col-md-1']) !!}
                    </div><div class="clearfix"> </div>
              
                
                </span>
            </div>
        </div><div class="clearfix"> </div>
               
    </section>

    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop