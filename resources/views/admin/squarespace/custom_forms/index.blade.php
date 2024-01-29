@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Squarespace Custom Forms Index</span>
                        @can('create-group')
                            <span class="create">
                                <a href="{{ action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'create']) }}">
                                   {{ html()->img(asset('images/create.png'), 'Add Custom Form')->attribute('title', "Add Custom Form")->class('btn btn-primary') }}
                                </a>

                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($custom_forms->isEmpty())
                    <p>It is a brand new world, there are custom forms!</p>
                @else
                <table class="table table-bordered table-striped table-responsive"><caption><h2>Custom Forms</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($custom_forms as $custom_form)
                        <tr>
                            <td><a href="{{URL('admin/squarespace/custom_form/'.$custom_form->id) }}">{{ $custom_form->name }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
