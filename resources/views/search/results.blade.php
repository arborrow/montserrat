@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">{{$persons->total()}} results found</span>
                    <span class="search"><a href={{ action('SearchController@search') }}>{!! Html::image('images/search.png', 'New search',array('title'=>"New search",'class' => 'btn btn-link')) !!}</a></span></h1>
                </div>
                @if ($persons->isEmpty())
                    <p>Oops, no known contacts with the given search criteria</p>
                @else
                <table class="table table-striped table-bordered table-hover"><caption><h2>Contacts</h2></caption>
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
                                    <div class="alert alert-warning alert-important"><strong>Do Not Mail</strong></div>
                                @endIf
                                {!!$person->address_primary_google_map!!}
                            </td>
                            <td>
                                @if($person->do_not_phone)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($person->do_not_sms)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($person->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                                @endif
                                @endforeach

                            <td>

                                @if($person->do_not_phone)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($person->do_not_sms)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($person->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                                @endif
                                @endforeach
                            </td>
                            <td>

                                @if($person->do_not_email)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Email</strong></div>
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
                    {{ $persons->links() }}
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
