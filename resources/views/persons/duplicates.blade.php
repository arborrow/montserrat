@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">List of duplicated sort_name ({{$duplicates->total()}} records)</span>
                </div>

                @if ($duplicates->isEmpty())
                    <p>It is a brand new world, there are no persons!</p>
                @else
                <table class="table table-striped table-bordered table-hover table-responsive"><caption><h2>Persons</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($duplicates as $duplicate)
                        <tr>
                            <td>{!!$duplicate->avatar_small_link!!}</td>
                            <td><a href="{!!url('person/merge/'.$duplicate->id)!!}">{{$duplicate->full_name}}</a></td>
                            <td>
                                @if($duplicate->do_not_mail)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Mail</strong></div>
                                @endIf
                                {!!$duplicate->address_primary_google_map!!}
                            </td>
                            <td>
                                @if($duplicate->do_not_phone)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($duplicate->do_not_sms)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($duplicate->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                                @endif
                                @endforeach

                            <td>

                                @if($duplicate->do_not_phone)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                                @endIf
                                @if($duplicate->do_not_sms)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                                @endIf
                                @foreach($duplicate->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                                @endif
                                @endforeach
                            </td>
                            <td>

                                @if($duplicate->do_not_email)
                                    <div class="alert alert-warning alert-important"><strong>Do Not Email</strong></div>
                                @endIf
                                @foreach($duplicate->emails as $email)
                                @if ($email->is_primary)
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a>
                                @endif
                                @endforeach
                            </td>

                        </tr>
                        @endforeach
                    {!! $duplicates->render() !!}
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
