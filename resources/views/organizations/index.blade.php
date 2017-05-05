@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Organization Index</span> 
                    <span class="grey">({{$organizations->total()}} records)</span> 
                    @can('create-contact')
                        <span class="create">
                            <a href={{ action('OrganizationsController@create') }}>{!! Html::image('img/create.png', 'Create a Diocese',array('title'=>"Create Diocese",'class' => 'btn btn-primary')) !!}</a>
                        </span>
                    @endCan
                    </h1>
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">Filter by organization type...</option>
                        <option value="{{url('organization')}}">All organizations</option>
                        @foreach($subcontact_types as $subcontact_type=>$value)
                            <option value="{{url('organization/type/'.$value)}}">{{$subcontact_type}}</option>
                        @endForeach
                    </select>

                </div>
                @if ($organizations->isEmpty())
                    <p>No Organizations are currently in the database.</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Organizations</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th> 
                            <th>Type</th>
                            <th>Address</th> 
                            <th>Main phone</th> 
                            <th>Email(s)</th> 
                            <th>Website(s)</th> 
                       </tr>
                    </thead>
                    <tbody>
                       @foreach($organizations as $organization)
                        <tr>
                            <td>{!!$organization->avatar_small_link!!}</td>
                            <td><a href="{{url('organization/'.$organization->id)}}">{{ $organization->display_name }} </a></td>
                            <td>{{$organization->subcontact_type_label}}</td>
                            <td>
                                @foreach($organization->addresses as $address)
                                @if ($address->is_primary)
                                {!!$address->google_map!!} 
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if (!empty($organization->phone_main_phone_number)) 
                                    <a href="tel:{{ $organization->phone_main_phone_number }}"> {{ $organization->phone_main_phone_number }} </a>
                                @else
                                    N/A
                                @endIf
                            </td>
                            <td> 
                                <a href="mailto:{{ $organization->email_primary_text }}">{{ $organization->email_primary_text }}</a> 
                            </td>
                            <td>
                                
                                @foreach($organization->websites as $website)
                                 @if(!empty($website->url))
                                <a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                                @endif
                                @endforeach
                                
                            </td>
                        </tr>
                        @endforeach
                    {!! $organizations->render() !!}    
                      
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop