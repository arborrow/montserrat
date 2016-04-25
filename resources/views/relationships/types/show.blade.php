@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Relationship Type Details</h2></span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Name A_B: </strong>{{$relationship_type->name_a_b}}
                        <br /><strong>Label A_B: </strong>{{$relationship_type->label_a_b}}
                        <br /><strong>Name B_A: </strong>{{$relationship_type->name_b_a}}
                        <br /><strong>Label B_A: </strong>{{$relationship_type->label_b_a}}  
                        <br /><strong>Description: </strong>{{$relationship_type->description}}     
                        <br /><strong>Active: </strong>{{$relationship_type->is_active}}
                        <br /><strong>Reserved: </strong>{{$relationship_type->is_reserved}}
                    
                </div>
            </div>
            
         
        </div>
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('RelationshipTypesController@edit', $relationship_type->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['relationship_type.destroy', $relationship_type->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        
    </div>
</section>
@stop