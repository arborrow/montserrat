@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $department->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Location</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('department.update', [$department->id]))->open() }}
                {{ html()->hidden('id', $department->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $department->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Label', 'label') }}
                                        {{ html()->text('label', $department->label)->class('form-control') }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Description', 'description') }}
                                        {{ html()->textarea('description', $department->description)->class('form-control')->rows(3) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Parent', 'parent_id') }}
                                        {{ html()->select('parent_id', $parents, $department->parent_id)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Notes', 'notes') }}
                                        {{ html()->textarea('notes', $department->notes)->class('form-control')->rows(3) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Active:', 'is_active')->class('col-md-2') }}
                                        {{ html()->checkbox('is_active', $department->is_active, 1)->class('col-md-2') }}
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
