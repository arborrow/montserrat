@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Relationship Type Index</span> 
                    <span class="create"><a href={{ action([\App\Http\Controllers\RelationshipTypeController::class, 'create']) }}>{{ html()->img(asset('images/create.png'), 'Add Group')->attribute('title', "Add Group")->class('btn btn-primary') }}</a></span></h1>
                
                </div>
                @if ($relationship_types->isEmpty())
                    <p>It is a brand new world, there are no relationship types!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Relationship Types</h2></caption>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Name A_B</th>
                            <th>Label A_B</th>
                            <th>Name B_A</th>
                            <th>Label B_A</th>
                            <th># of Relationships</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relationship_types as $relationship_type)
                        <tr>
                            <td><a href="relationship_type/{{ $relationship_type->id }}">{{ $relationship_type->description }}</a></td>
                            <td>{{ $relationship_type->name_a_b }}</td>
                            <td>{{ $relationship_type->label_a_b }}</td>
                            <td>{{ $relationship_type->name_b_a }}</td>
                            <td>{{ $relationship_type->label_b_a }}</td>
                            <td>N/A</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop