@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create department</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/department')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Name', 'name') }}
                        {{ html()->text('name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Label', 'label') }}
                        {{ html()->text('label')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Description', 'description') }}
                        {{ html()->textarea('description')->class('form-control')->rows(3) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Parent', 'parent_id') }}
                        {{ html()->select('parent_id', $parents)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Notes', 'notes') }}
                        {{ html()->textarea('notes')->class('form-control')->rows(3) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                        {{ html()->checkbox('is_active', true, 1)->class('col-md-1') }}
                    </div>
                </div>

            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add department')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
