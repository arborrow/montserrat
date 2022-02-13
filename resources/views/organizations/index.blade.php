@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Organizations
            @can('create-contact')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\OrganizationController::class, 'create']) }}>
                        {!! Html::image('images/create.png', 'Create Organization',array('title'=>"Create Organization",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
            @endCan
        </h1>
        <p class="lead">{{$organizations->total()}} records</p>
        <form>
            <div class="form-row">
                <div class="col-lg-3">
                    <select class="custom-select" id="org_type" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option value="">Filter by type</option>
                        <option value="{{url('organization')}}">All organizations</option>
                        @foreach($subcontact_types as $subcontact_type=>$value)
                            <option value="{{url('organization/type/'.$value)}}">{{$subcontact_type}}</option>
                        @endForeach
                    </select>
                    {{-- JavaScript to keep the correct option selected on page reload --}}
                    <script>
                        var selectElement = document.querySelector('#org_type');
                        selectElement.childNodes.forEach(function(child) {
                            console.log(child);
                            if (child.value == window.location)
                                child.setAttribute('selected', '');
                        });
                    </script>
                    {{-- --}}
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-12">
        @if ($organizations->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>No Organizations are currently in the database.</p>
            </div>
        @else
        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Address</th>
                    <th scope="col">Main phone</th>
                    <th scope="col">Email(s)</th>
                    <th scope="col">Website(s)</th>
               </tr>
            </thead>
            <tbody>
               @foreach($organizations as $organization)
                <tr>
                    <th scope="row">{!!$organization->avatar_small_link!!}</th>
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
                {{ $organizations->links() }}
            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
