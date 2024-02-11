@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $asset_type->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Asset type</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('asset_type.update', [$asset_type->id]))->open() }}
                {{ html()->hidden('id', $asset_type->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $asset_type->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Label', 'label') }}
                                        {{ html()->text('label', $asset_type->label)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Description', 'description') }}
                                        {{ html()->text('description', $asset_type->description)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Parent asset type', 'parent_asset_type_id') }}
                                        {{ html()->select('parent_asset_type_id', $asset_types, $asset_type->parent_asset_type_id)->class('form-control') }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Active:', 'is_active')->class('col-md-2') }}
                                        {{ html()->checkbox('is_active', $asset_type->is_active, 1)->class('col-md-2') }}
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
