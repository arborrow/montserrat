@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Departments
            @can('create-department')
            <span class="options">
                <a href={{ action([\App\Http\Controllers\DepartmentController::class, 'create']) }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
        </h2>
    </div>

    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($departments->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no departments!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Label</th>
                    <th scope="col">Description</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                <tr>
                    <td><a href="{{URL('admin/department/'.$department->id)}}">{{ $department->name }}</a></td>
                    <td>{{ $department->label }}</td>
                    <td>{{ $department->description }}</td>
                    <td>{{ $department->notes }}</td>
                    <td>{{ $department->parent_name }}</td>
                    <td>{{ $department->is_active ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
