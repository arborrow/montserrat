@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Vendor Index</span> 
                        <span class="grey">({{$vendors->count()}} records)</span> 
                        @can('update-contact')
                            <span class="create">
                                <a href={{ action('VendorsController@create') }}>{!! Html::image('img/create.png', 'Create a Vendor',array('title'=>"Create Vendor",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                    </h1>
             
                </div>
                @if ($vendors->isEmpty())
                    <p>No vendors are currently in the database.</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Vendors</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th> 
                            <th>Address</th> 
                            <th>Phone</th> 
                            <th>Email</th> 
                            <th>Webpage</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $vendor)
                        <tr>
                            <td>{!!$vendor->avatar_small_link!!}</td>
                            <td><a href="vendor/{{$vendor->id}}">{{ $vendor->organization_name }} </a></td>
                            <td>
                                @foreach($vendor->addresses as $address)
                                @if ($address->is_primary)
                                    {!!$address->google_map!!} 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($vendor->phones as $phone)
                                @if (($phone->location_type_id==3) and ($phone->phone_type=="Phone"))  
                                <a href="tel:{{ $phone->phone }}"> {{ $phone->phone }}</a>
                                @endif
                                @endforeach
                            </td>
                            <td> 
                                @foreach($vendor->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                
                                @foreach($vendor->websites as $website)
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