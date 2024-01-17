@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $role->name !!}</h1>    
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Permission Details</h2>    
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('role.update', [$role->id]))->open() }}
                {{ html()->hidden('id', $role->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $role->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Display name', 'display_name') }}
                                        {{ html()->text('display_name', $role->display_name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Description', 'description') }}
                                        {{ html()->text('description', $role->description)->class('form-control') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                        </div>
                    </div>
                {{ html()->form()->close() }}  
            </div>
        </div>    
    </div>  
</div>
@stop