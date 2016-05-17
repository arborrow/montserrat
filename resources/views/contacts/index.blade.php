@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Contact Index</span> 
                    <span class="create"><a href={{ action('ContactsController@create') }}>{!! Html::image('img/create.png', 'Add Contact',array('title'=>"Add Contact",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($contacts->isEmpty())
                    <p>It is a brand new world, there are no contacts!</p>
                @else
                <table class="table"><caption><h2>Contacts</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Parish (Diocese)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td><a href="contact/{{ $contact->id}}">{{ $contact->last_name }}, {{ $contact->first_name }}</a></td>
                            <td>
                                @foreach($contact->addresses as $address)
                                @if ($address->is_primary)
                                    {!!$address->google_map!!} 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($contact->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))  
                                {{ $phone->phone }} 
                                @endif
                                @endforeach
                                
                            <td>
                                @foreach($contact->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))  
                                {{ $phone->phone }} 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($contact->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if (!isset($contact->parish))
                                    N/A
                                @else
                                <a href="parish/{{$contact->parish->id}}">{{ $contact->parish->name }}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        {!! $contacts->render() !!}
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop