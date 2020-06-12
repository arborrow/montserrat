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
                                    <option value="{{url('dashboard/description/bookstore')}}">Bookstore</option>
                                    <option value="{{url('dashboard/description/deposit')}}">Deposits</option>
                                    <option value="{{url('dashboard/description/diocese')}}">Diocesan events</option>
                                    <option value="{{url('dashboard/description/donation')}}">Donations</option>
                                    <option value="{{url('dashboard/description/flower')}}">Flowers</option>
                                    <option value="{{url('dashboard/description/gift')}}">Gift Certificates</option>
                                    <option value="{{url('dashboard/description/offering')}}">Retreat Offerings</option>
                                    <option value="{{url('dashboard/description/other')}}">Other events</option>
                                    <option value="{{url('dashboard/description/tip')}}">Tips</option>
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
