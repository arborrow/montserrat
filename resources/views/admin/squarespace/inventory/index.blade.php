@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Squarespace Inventory Index</span>
                        @can('create-group')
                            <span class="create">
                                <a href="{{ action([\App\Http\Controllers\SquarespaceInventoryController::class, 'create']) }}">
                                   {!! Html::image('images/create.png', 'Add Squarespace Inventory',array('title'=>"Add Squarespace Inventory",'class' => 'btn btn-primary')) !!}
                                </a>

                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($inventory_items->isEmpty())
                    <p>It is a brand new world, there are no Squarespace Inventory items!</p>
                @else
                <table class="table table-bordered table-striped table-responsive">
                    <caption><h2>Squarespace Inventory</h2></caption>
                    <thead>
                        <tr>
                            <th style="width:25%">Name</th>
                            <th>Custom Form</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory_items as $item)
                        <tr>
                            <td><a href="{{URL('admin/squarespace/inventory/'.$item->id) }}">{{ $item->name }}</a></td>
                            <td><a href="{{ URL('admin/squarespace/custom_form/' . $item->custom_form_id) }}">{{ $item->custom_form->name }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
