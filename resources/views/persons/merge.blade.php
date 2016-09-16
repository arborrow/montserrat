@extends('template')
@section('content')
<h1>Merging users</h1>
<table class="table table-bordered table-striped">
    <tr>
    <th>Contact ID</th>
    <th><a href="{!!url('admin/merge/'.$contact->id)!!}">{{$contact->id}}</a></th>
    @foreach ($duplicates as $duplicate)
    <th><a href="{!!url('admin/merge/'.$duplicate->id)!!}">{{$duplicate->id}}</a>
        <br />
        <span class='btn btn-default'>
            <a href="{!!url('admin/merge/'.$contact->id.'/'.$duplicate->id)!!}">Merge</a>
        </span>
        <span class='btn btn-default'>
            <a href="{!!url('admin/merge_delete/'.$duplicate->id)!!}">Delete</a>
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
