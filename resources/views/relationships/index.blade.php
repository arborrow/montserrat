@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Relationship Index</span>
                    <span class="create"><a href={{ action([\App\Http\Controllers\RelationshipController::class, 'create']) }}>{!! Html::image('images/create.png', 'Add Relationship',array('title'=>"Add Relationship",'class' => 'btn btn-primary')) !!}</a></span></h1>

                </div>
                @if ($relationships->isEmpty())
                    <p>It is a brand new world, there are no relationships!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Relationship Types</h2></caption>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Relationship Type</th>
                            <th>Contact A</th>
                            <th>Contact B</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Is Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relationships as $relationship)
                        <tr>
                            <td><a href="relationship/{{ $relationship->id }}">{{ $relationship->description }}</a></td>
                            <td>{{ $relationship->relationship_type_id }}</td>
                            <td>{!! $relationship->contact_a->contact_link !!}</td>
                            <td>{!! $relationship->contact_b->contact_link !!}</td>
                            <td>{{ $relationship->start_date }}</td>
                            <td>{{ $relationship->end_date }}</td>
                            <td>{{ $relationship->is_active }}</td>
                            <td>{{ $relationship->label_b_a }}</td>
                            <td>N/A</td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
                {{ $relationships->links() }}
            </div>
        </div>
    </section>
@stop
