@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Person Index</span> 
                        <span>({{$persons->total()}} records)</span>
                        @can('create-contact')
                            <span class="create">
                                <a href={{ action('PersonController@create') }}>{!! Html::image('img/create.png', 'Add Person',array('title'=>"Add Person",'class' => 'btn btn-link')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                    <span class="boards"><a href={{ action('PersonController@boardmembers') }}>{!! Html::image('img/board.png', 'Board members',array('title'=>"Board members",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="captains"><a href={{ action('PersonController@captains') }}>{!! Html::image('img/captain.png', 'Captains',array('title'=>"Captains",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="staff"><a href={{ action('PersonController@staff') }}>{!! Html::image('img/employee.png', 'Employees',array('title'=>"Employees",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="steward"><a href={{ action('PersonController@stewards') }}>{!! Html::image('img/steward.png', 'Stewards',array('title'=>"Stewards",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="volunteers"><a href={{ action('PersonController@volunteers') }}>{!! Html::image('img/volunteer.png', 'Volunteers',array('title'=>"Volunteers",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="directors"><a href={{ action('PersonController@directors') }}>{!! Html::image('img/director.png', 'Directors',array('title'=>"Directors",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="innkeepers"><a href={{ action('PersonController@innkeepers') }}>{!! Html::image('img/innkeeper.png', 'Innkeepers',array('title'=>"Innkeepers",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="assistants"><a href={{ action('PersonController@assistants') }}>{!! Html::image('img/assistant.png', 'Assistants',array('title'=>"Assistants",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="bishops"><a href={{ action('PersonController@bishops') }}>{!! Html::image('img/bishop.png', 'Bishops',array('title'=>"Bishops",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="pastors"><a href={{ action('PersonController@pastors') }}>{!! Html::image('img/pastor.png', 'Pastors',array('title'=>"Pastors",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="priests"><a href={{ action('PersonController@priests') }}>{!! Html::image('img/priest.png', 'Priests',array('title'=>"Priests",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="deacons"><a href={{ action('PersonController@deacons') }}>{!! Html::image('img/deacon.png', 'Deacons',array('title'=>"Deacons",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="provincials"><a href={{ action('PersonController@provincials') }}>{!! Html::image('img/provincial.png', 'Provincials',array('title'=>"Provincials",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="superiors"><a href={{ action('PersonController@superiors') }}>{!! Html::image('img/superior.png', 'Superiors',array('title'=>"Superiors",'class' => 'btn btn-info')) !!}</a></span>
                    <span class="jesuits"><a href={{ action('PersonController@jesuits') }}>{!! Html::image('img/jesuit.png', 'Jesuits',array('title'=>"Jesuits",'class' => 'btn btn-info')) !!}</a></span>
                    <!-- <span class="donors"><a href={{ action('PersonController@donors') }}>{!! Html::image('img/donor.png', 'Donors',array('title'=>"Donors",'class' => 'btn btn-info')) !!}</a></span></h1> -->
                    <!-- <span class="retreatants"><a href={{ action('PersonController@retreatants') }}>{!! Html::image('img/retreatant.png', 'Retreatants',array('title'=>"Retreatants",'class' => 'btn btn-info')) !!}</a></span></h1> -->
                
                </div>
                
                @if ($persons->isEmpty())
                    <p>It is a brand new world, there are no persons. Let there be light!</p>
                @else
                <table class="table table-striped table-bordered table-hover"><caption><h2>Persons</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Parish (City)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($persons as $person)
                        <tr>
                            <td>{!!$person->avatar_small_link!!}</td>
                            <td>{!!$person->contact_link_full_name!!}</td>
                            <td>
                                @if($person->do_not_mail)
                                    <div class="alert alert-warning"><strong>Do Not Mail</strong></div>
                                @endIf
                                {!!$person->address_primary_google_map!!} 
                            </td>
                            <td>
                                @if($person->do_not_phone)
                                    <div class="alert alert-warning"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($person->do_not_sms)
                                    <div class="alert alert-warning"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($person->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                                
                            <td>
                                
                                @if($person->do_not_phone)
                                    <div class="alert alert-warning"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($person->do_not_sms)
                                    <div class="alert alert-warning"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($person->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                
                                @if($person->do_not_email)
                                    <div class="alert alert-warning"><strong>Do Not Email</strong></div>
                                @endIf
                                @foreach($person->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                {!! $person->parish_link !!}
                            </td>
                        </tr>
                        @endforeach
                    {!! $persons->render() !!}    
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop