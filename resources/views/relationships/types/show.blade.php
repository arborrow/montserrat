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
                        <strong>Description: </strong>{{$relationship_type->description}}
                        <hr />
                        <strong>Name A_B: </strong>{{$relationship_type->name_a_b}}
                        <br /><strong>Label A_B: </strong>{{$relationship_type->label_a_b}}
                        <br /><strong>Contact A Type: </strong>{{$relationship_type->contact_sub_type_a ?? $relationship_type->contact_type_a }}
                        <hr />
                        <strong>Name B_A: </strong>{{$relationship_type->name_b_a}}
                        <br /><strong>Label B_A: </strong>{{$relationship_type->label_b_a}}
                        <br /><strong>Contact B Type: </strong>{{$relationship_type->contact_sub_type_b ?? $relationship_type->contact_type_b}}
                        <hr />
                        <strong>Active: </strong>{{$relationship_type->is_active}}
                        <br /><strong>Reserved: </strong>{{$relationship_type->is_reserved}}

                </div>
            </div>

        <div class='row'>
            <div class='col-md-8'>
                <div class='panel-heading'>
                    <h2><strong>Relationships of type: {{ $relationship_type->name_a_b }} </strong></h2>
                </div>
                    @if ($relationships->isEmpty())
                        <p>No relationships of this type are currently defined.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Contact A</th>
                                    <th>Relationship</th>
                                    <th>Contact B</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relationships as $relationship)
                                <tr>
                                    <td>{{$relationship->contact_a->display_name}}</td>
                                    <td>{{$relationship_type->label_a_b}}</td>
                                    <td>{{$relationship->contact_b->display_name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        </div>
            <div class='row'>
                <div class='col-md-1'><a href="{{ action([\App\Http\Controllers\RelationshipTypeController::class, 'edit'], $relationship_type->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['relationship_type.destroy', $relationship_type->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>

    </div>
</section>
@stop
