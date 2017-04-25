@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2><strong>
                        @can('update-donor')
                            {!! Html::link(url('donor/'.$donor->donor_id.'/edit'),$donor->sort_name) !!} 
                        @else
                            {{$donor->name}} group
                        @endCan
                        </strong></h2>
                </span>
                
            </div>
            <div class="clearfix"> </div>
             
            <table class="table table-striped table-bordered table-hover"><caption><h2>PPD Donor Record: {{$donor->donor_id}}</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Work phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>{{$donor->LName.', '.$donor->FName}}</td>
                            <td>{{$donor->Address.' '.$donor->Address2.' '.$donor->City.', '.$donor->State.' '.$donor->Zip}}</td>
                            <td>{{$donor->HomePhone}} </td>
                            <td>{{$donor->WorkPhone}}</td>
                            <td>{{$donor->cell_phone}}</td>
                            <td>{{$donor->EMailAddress}}</td>
                            <td> 
                                <span class="btn btn-default">
                                    <a href="{{ url('donor/'.$donor->donor_id.'/add') }}">Add {{$donor->sort_name}} to Polanco</a>
                                </span>
                            </td>
                            
                        </tr>
                     
                    </tbody>
                </table>
                
            <div class="clearfix"> </div>
                <table class="table table-striped table-bordered table-hover"><caption><h2>Matching Polanco Contact sort_name(s)</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sortnames as $sortname)
                        <tr>
                            <td>{!!$sortname->contact_link_full_name!!}</td>
                            <td>{!!$sortname->address_primary_google_map!!}</td>
                            <td>
                                @foreach($sortname->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                                
                            <td>
                                @foreach($sortname->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($sortname->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="btn btn-default">
                                    <a href="{{ url('donor/'.$donor->donor_id.'/assign/'.$sortname->id) }}">Assign {{$sortname->id  }}</a>
                                </span>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                     
                    </tbody>
                </table>
                
                <table class="table table-striped table-bordered table-hover"><caption><h2>Matching Polanco Contact lastname(s)</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lastnames as $lastname)
                        <tr>
                            <td>{!!$lastname->contact_link_full_name!!}</td>
                            <td>{!!$lastname->address_primary_google_map!!}</td>
                            <td>
                                @foreach($lastname->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                                
                            <td>
                                @foreach($lastname->phones as $phone)
                                @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))  
                                <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($lastname->emails as $email)
                                @if ($email->is_primary)  
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a> 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="btn btn-default">
                                    <a href="{{ url('donor/'.$donor->donor_id.'/assign/'.$lastname->id) }}">Assign {{$lastname->id  }}</a>
                                </span>
                                
                            </td>
                            
                        </tr>
                    @endforeach
                     
                    </tbody>
                </table>
                
            
            <div class="clearfix"> </div>
        </div>
        
        <div class='row'>
            <div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop