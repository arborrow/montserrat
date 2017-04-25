@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Relationship Type</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['relationship_type.update', $relationship_type->id]]) !!}
    {!! Form::hidden('id', $relationship_type->id) !!}
    
        <span><h2>Relationship Type Details</h2>
            <div class="form-group">
                 <div class='row'>
                    {!! Form::label('name_a_b', 'Name A-B:', ['class' => 'col-md-1'])  !!}

                    {!! Form::text('name_a_b', $relationship_type->name_a_b, ['class' => 'col-md-3']) !!}
                    {!! Form::label('label_a_b', 'Label A-B:', ['class' => 'col-md-1'])  !!}

                    {!! Form::text('label_a_b', $relationship_type->label_a_b, ['class' => 'col-md-3']) !!}
                </div>
                <div class='row'>
                    {!! Form::label('name_b_a', 'Name B-A:', ['class' => 'col-md-1'])  !!}

                    {!! Form::text('name_b_a', $relationship_type->name_b_a, ['class' => 'col-md-3']) !!}
                    {!! Form::label('label_b_a', 'Label B-A:', ['class' => 'col-md-1'])  !!}

                    {!! Form::text('label_b_a', $relationship_type->label_b_a, ['class' => 'col-md-3']) !!}
                </div>
                <div class='row'>
                    {!! Form::label('description', 'Description:', ['class' => 'col-md-1'])  !!}
                    {!! Form::textarea('description', $relationship_type->description, ['class' => 'col-md-3']) !!}                   
                </div>             
                <div class="form-group">
                    {!! Form::label('is_active', 'Active:', ['class' => 'col-md-1'])  !!}
                    {!! Form::checkbox('is_active', true, $relationship_type->is_active,['class' => 'col-md-1']) !!}
                    {!! Form::label('is_reserved', 'Reserved:', ['class' => 'col-md-1'])  !!}
                    {!! Form::checkbox('is_reserved', false, $relationship_type->is_reserved, ['class' => 'col-md-1']) !!}
                </div>
                <div class="clearfix"> </div>
    
            </div>
        </span>
                
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop