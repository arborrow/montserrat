@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {!! $asset_type->name !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Asset type</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['asset_type.update', $asset_type->id]]) !!}
                {!! Form::hidden('id', $asset_type->id) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('name', 'Name')  !!}
                                        {!! Form::text('name', $asset_type->name, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('label', 'Label')  !!}
                                        {!! Form::text('label', $asset_type->label, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('description', 'Description')  !!}
                                        {!! Form::text('description', $asset_type->description, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('parent_asset_type_id', 'Parent asset type')  !!}
                                        {!! Form::select('parent_asset_type_id', $asset_types, $asset_type->parent_asset_type_id, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('is_active', 'Active:', ['class' => 'col-md-2'])  !!}
                                        {!! Form::checkbox('is_active', 1, $asset_type->is_active,['class' => 'col-md-2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
