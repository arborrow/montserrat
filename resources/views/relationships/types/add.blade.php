@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        {{ html()->form('POST', url('relationship/add'))->class('form-horizontal panel')->open() }}
        {{ html()->hidden('relationship_type_id', $relationship_type->id) }}
        {{ html()->hidden('direction', $direction) }}
        @if ($direction == 'a')
            <h3>{{$primary_contact->full_name}} is {{$relationship_type->label_a_b}}:</h3><br />
            <div class='row'>
                {{ html()->label($relationship_type->name_b_a, 'contact_b_id')->class('col-md-2 font-weight-bold') }}
                {{ html()->select('contact_b_id', $contact_list)->class('col-md-3')->autofocus('autofocus') }}            
                {{ html()->hidden('contact_a_id', $primary_contact->id) }}
            </div>
        @else
            <h3>{{$primary_contact->full_name}} is {{$relationship_type->label_b_a}}:</h3><br />
            <div class='row'>
                {{ html()->label($relationship_type->name_a_b, 'contact_a_id')->class('col-md-2 font-weight-bold') }}
                {{ html()->select('contact_a_id', $contact_list)->class('col-md-3')->autofocus('autofocus') }}            
                {{ html()->hidden('contact_b_id', $primary_contact->id) }}
            </div>
        @endIf
        <div class="clearfix"> </div>
        <br />
        <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add ' . $relationship_type->description . ' Relationship')->class('btn btn-primary') }}
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</section>
@stop