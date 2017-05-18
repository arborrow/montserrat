@extends('template')
@section('content')
<h1>Merging users</h1> - <span class='btn btn-default'><a href="{!!url('person/duplicates')!!}">List of Duplicates</a></span>
<table class="table table-bordered table-striped">
    <tr>
    <th>Contact ID</th>
    <th><a href="{!!url('person/merge/'.$contact->id)!!}">{{$contact->id}}</a></th>
    @foreach ($duplicates as $duplicate)
    <th><a href="{!!url('person/merge/'.$duplicate->id)!!}">{{$duplicate->id}}</a>
        <br />
        <span class='btn btn-default'>
            <a href="{!!url('person/merge/'.$contact->id.'/'.$duplicate->id)!!}">Merge</a>
        </span>
        <span class='btn btn-default'>
            <a href="{!!url('person/merge_delete/'.$duplicate->id.'/'.$contact->id)!!}">Delete</a>
        </span>
        
    </th>
    @endforeach
    </tr>
    <tr>
        <td><strong>sort_name</strong></td>
        <td>{{$contact->sort_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->sort_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Full name</strong></td>
        <td>{!!$contact->contact_link_full_name!!}</td>
        @foreach ($duplicates as $duplicate)
            <td>{!!$duplicate->contact_link_full_name!!}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Address</strong></td>
        <td>{{$contact->address_primary_street}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->address_primary_street}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>City</strong></td>
        <td>{{$contact->address_primary_city}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->address_primary_city}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Zip</strong></td>
        <td>{{$contact->address_primary_postal_code}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->address_primary_postal_code}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of Addresses</strong></td>
        <td>{{$contact->addresses->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->addresses->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Home Phone</strong></td>
        <td>{{$contact->phone_home_phone_number}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->phone_home_phone_number}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Cell Phone</strong></td>
        <td>{{$contact->phone_home_mobile_number}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->phone_home_mobile_number}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Main Phone</strong></td>
        <td>{{$contact->phone_main_phone_number}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->main_home_phone_number}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Email</strong></td>
        <td>{{$contact->email_primary_text}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->email_primary_text}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Emergency Name</strong></td>
        <td>{{$contact->emergency_contact_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->emergency_contact_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Emergency Relationship</strong></td>
        <td>{{$contact->emergency_contact_relationship}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->emergency_contact_relationship}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Emergency - Phone</strong></td>
        <td>{{$contact->emergency_contact_phone}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->emergency_contact_phone}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Emergency - Alt. Phone</strong></td>
        <td>{{$contact->emergency_contact_phone_alternate}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->emergency_contact_phone_alternate}}</td>
        @endforeach
    </tr>
    
    <tr>
        <td><strong>Gender</strong></td>
        <td>{{$contact->gender_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->gender_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>DOB</strong></td>
        <td>{{$contact->birth_date}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->birth_date}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Religion</strong></td>
        <td>{{$contact->religion_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->religion_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Occupation</strong></td>
        <td>{{$contact->occupation_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->occupation_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Ethnicity</strong></td>
        <td>{{$contact->ethnicity_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->ethnicity_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Parish</strong></td>
        <td>{{$contact->parish_name}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->parish_name}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Deceased</strong></td>
        <td>{{$contact->is_deceased}}:{{$contact->deceased_date}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->is_deceased}}:{{$duplicate->deceased_date}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of Notes</strong></td>
        <td>{{$contact->notes->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->notes->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of Groups</strong></td>
        <td>{{$contact->groups->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->groups->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of A Relationships</strong></td>
        <td>{{$contact->a_relationships->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->a_relationships->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of B Relationships</strong></td>
        <td>{{$contact->b_relationships->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->b_relationships->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of Touchpoints</strong></td>
        <td>{{$contact->touchpoints->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->touchpoints->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of File Attachments</strong></td>
        <td>{{$contact->attachments->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->attachments->count()}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong># of Event Registrations</strong></td>
        <td>{{$contact->event_registrations->count()}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->event_registrations->count()}}</td>
        @endforeach
    </tr>
    
    
    <tr>
        <td><strong>Contact Type</strong></td>
        <td>{{$contact->contact_type_label}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->contact_type_label}}</td>
        @endforeach
    </tr>
    <tr>
        <td><strong>Subcontact Type</strong></td>
        <td>{{$contact->subcontact_type_label}}</td>
        @foreach ($duplicates as $duplicate)
            <td>{{$duplicate->subcontact_type_label}}</td>
        @endforeach
    </tr>

</table>        
@stop
