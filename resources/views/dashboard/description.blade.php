@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Donation Description Dashboard</span>
                    </h1>
                </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Filter by Donation Description ...</option>
                                @foreach($descriptions as $description)
                                    <option value="{{url('dashboard/description/'.$description)}}">{{ $description }}</option>
                                @endForeach
                            </select>
                        </div>
                    </div>


                <div> {!! $donation_description_chart->container() !!} </div>
            </div>
        </div>
    </section>
    {!! $donation_description_chart->script() !!}

@stop
