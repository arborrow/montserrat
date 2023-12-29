@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Permission</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/permission')->class('form-horizontal panel')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Name', 'name') }}
                        {{ html()->text('name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Display Name', 'display_name') }}
                        {{ html()->text('display_name')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Description', 'description') }}
                        {{ html()->textarea('description')->class('form-control')->rows(3) }} 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    {{ html()->submit('Add Permission')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop