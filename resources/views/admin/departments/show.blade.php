@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-department')
        <h1>
            Department details: <strong><a href="{{url('admin/department/'.$department->id.'/edit')}}">{{ $department->name }}</a></strong>
        </h1>
        @else
        <h1>
            Department details: <strong>{{$department->name}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Label: </span> {{$department->label}}<br />
        <span class="font-weight-bold">Description: </span> {{$department->description}}<br />
        <span class="font-weight-bold">Notes: </span> {{$department->notes}}<br />
        @if (! empty($department->parent_id))
            <span class="font-weight-bold">Parent: </span> <a href = "{{URL('admin/department/'.$department->parent_id)}}">{{$department->parent_name}}</a><br />
        @else
            <span class="font-weight-bold">Parent: </span> Unspecified<br />
        @endIf
        <span class="font-weight-bold">Active: </span>{{$department->is_active ? 'Yes':'No'}}
    </div>


    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($children->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>This department does not have any sub-departments</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <caption>Sub-departments</caption>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Label</th>
                    <th scope="col">Description</th>
                    <th scope="col">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($children as $child)
                <tr>
                    <td><a href="{{URL('admin/department/'.$child->id)}}">{{ $child->name }}</a></td>
                    <td>{{ $child->label }}</td>
                    <td>{{ $child->description }}</td>
                    <td>{{ $child->notes }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>

    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-department')
                    <a href="{{ action([\App\Http\Controllers\DepartmentController::class, 'edit'], $department->id) }}" class="btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-department')
                    {{ html()->form('DELETE', route('department.destroy', [$department->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
