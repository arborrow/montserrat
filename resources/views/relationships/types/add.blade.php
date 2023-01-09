@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Add a {{$relationship_type->description}} Relationship</strong></h2>

        <div class="row">
            <div class="col-lg-3 col-md-4">
                <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Filter by ...</option>
                    <option value="{{url('relationship_type/'.$relationship_type->id.'/add/'.$a.'/'.$b.'/all')}}">All retreats</option>
                    <option value="{{url('relationship_type/'.$relationship_type->id.'/add/'.$a.'/'.$b.'/lastname')}}">Lastname</option>
                    <option value="{{url('relationship_type/'.$relationship_type->id.'/add/'.$a.'/'.$b.'/matched')}}">Matched</option>
                </select>
            </div>
        </div>
        <br />
        {!! Form::open(['url' => 'relationship/add', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        {{ Form::hidden('relationship_type_id', $relationship_type->id) }}
        <span>
            <div class='row'>
                {!! Form::label('contact_a_id', $relationship_type->name_a_b, ['class' => 'col-md-1'])  !!}
                {!! Form::select('contact_a_id', $contact_a_list, 'Individual', ['class' => 'col-md-3']) !!}            
            </div>
            <div class='row'>
                {!! Form::label('contact_b_id', $relationship_type->name_b_a, ['class' => 'col-md-1'])  !!}
                {!! Form::select('contact_b_id', $contact_b_list, 'Individual', ['class' => 'col-md-3']) !!}
            </div>
            <div class="clearfix"> </div>
            <br />
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::submit('Add '.$relationship_type->description, ['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </span>
    </div>
</section>
@stop