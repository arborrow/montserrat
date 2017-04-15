@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">PPD Donor Index</span>
                        <span>({{$donors->total()}} records)</span>
                        
                        @can('create-donor')
                            <span class="create">
                                <a href="{{ action('DonorsController@create') }}">
                                   {!! Html::image('img/create.png', 'Add Donor',array('title'=>"Add Donor",'class' => 'btn btn-primary')) !!}
                                </a>
                 
                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($donors->isEmpty())
                    <p>It is a brand new world, there are no PPD donors!</p>
                @else
                <table class="table table-bordered table-striped"><caption><h2>PPD Donors (with no Polanco Contact Id)</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Donor ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donors as $donor)
                        <tr>
                            <td><a href="{{url('donor/'.$donor->donor_id)}}">{{ $donor->LName.', '.$donor->FName }}</a></td>
                            <td>{{ $donor->Address.' '.$donor->Address2.' '.$donor->City.', '.$donor->State.' '.$donor->Zip }}</td>
                            <td>{{ 'H:'.$donor->HomePhone.' W:'.$donor->WorkPhone.' M:'.$donor->cell_phone }}</td>
                            <td>{{ $donor->donor_id }}</td>
                            <td>
                                <!-- Add to Polanco (not yet implemented)-->
                            </td>
                            
                        </tr>
                        @endforeach
                       {!! $donors->render() !!}  
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop