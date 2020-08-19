@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Index of Users
        </h2>
        <p class="lead">{{$users->total()}} records</p>

    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($users->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no users!</p>
            </div>
        @else

            <table class="table table-striped table-bordered table-hover">
                {{ $users->render() }}
                <thead>
                    <tr>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><img src="{{ $user->avatar }}" alt="Avatar" height="50px" width="50px"></td>
                        <td>
                            <a href = "{{ URL('admin/user/' . $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <ul>
                                @foreach($user->roles as $role)
                                    <li>
                                        <a href = "{{ URL('admin/role/'.$role->id) }}">
                                            {{ $role->name }}
                                        </a>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
