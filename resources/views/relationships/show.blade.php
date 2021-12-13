@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Relationship Details for
            @can('update-relationship')
                <a href="{{url('relationship/'.$relationship->id.'/edit')}}">Relationship #{{ $relationship->id }}</a>
            @else
                Relationship #{{ $relationship->id }}
            @endCan
            <span class="back"><a href={{ action('RelationshipController@index') }}>{!! Html::image('images/relationship.png', 'relationship Index',array('title'=>"relationship Index",'class' => 'btn btn-light')) !!}</a>
        </h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12 col-md-4">
                <strong>Contact A: </strong>{!! $relationship->contact_a->contact_link_full_name!!}</a>
            </div>
            <div class="col-lg-12 col-md-4">
                <strong>Contact B: </strong>{!! $relationship->contact_b->contact_link_full_name!!}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-4">
                <strong>Relationship Type: </strong>{{ $relationship->relationship_type->description}}
            </div>
        </div>
        <div class="row">
              <div class="col-lg-12 col-md-4">
                  <strong>Relationship Description: </strong>{{ $relationship->description}}
              </div>
        </div>
        <div class="row">
                <div class="col-lg-12 col-md-4">
                    <strong>Start / End Dates: </strong>{{ $relationship->start_date }} / {{ $relationship->end_date }}
                </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-4">
                <strong>Is active: </strong>{{ $relationship->is_active ? 'Yes':'No' }}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 text-right">
                @can('update-relationship')
                    <a href="{{ action('RelationshipController@edit', $relationship->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-relationship')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
        </div>
    </div>
</div>
@stop
