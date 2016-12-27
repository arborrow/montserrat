@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Diocese Index</span>
                        <span class="grey">({{$dioceses->count()}} records)</span> 
                        @can('create-contact')
                            <span class="create">
                                <a href={{ action('DiocesesController@create') }}>{!! Html::image('img/create.png', 'Create a Diocese',array('title'=>"Create Diocese",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($dioceses->isEmpty())
                    <p>No Dioceses are currently in the database.</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Dioceses</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th> 
                            <th>Bishop</th> 
                            <th>Address</th> 
                            <th>Phone(s)</th> 
                            <th>Email(s)</th> 
                            <th>Website(s)</th> 
                       </tr>
                    </thead>
                    <tbody>
                       @foreach($dioceses as $diocese)
                        <tr>
                            <td>{!!$diocese->avatar_small_link!!}</td>
                            <td><a href="diocese/{{$diocese->id}}">{{ $diocese->organization_name }} </a></td>
                            <td>
                                @if (empty($diocese->bishops))
                                No Bishop(s) assigned 
                                @else
                                @foreach($diocese->bishops as $bishop)
                                <a href="person/{{$bishop->contact_id_b}}">{{ $bishop->contact_b->full_name}}</a>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @foreach($diocese->addresses as $address)
                                @if ($address->is_primary)
                                {!!$address->google_map!!} 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($diocese->phones as $phone)
                                @if (($phone->location_type_id==3) and ($phone->phone_type=="Phone"))  
                                <a href="tel:{{ $phone->phone }}"> {{ $phone->phone }}</a>
                                @endif
                                @endforeach
                            </td>
                            <td> 
                                @foreach($diocese->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                
                                @foreach($diocese->websites as $website)
                                 @if(!empty($website->url))
                                <a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                                @endif
                                @endforeach
                                
                            </td>
                        </tr>
                        @endforeach
                      
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop