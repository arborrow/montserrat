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
                {!! Form::open(['method' => 'PUT', 'route' => ['department.update', $department->id]]) !!}
                {!! Form::hidden('id', $department->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $department->name , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('label', 'Label') !!}
                                        {!! Form::text('label', $department->label , ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::label('description', 'Description') !!}
                                        {!! Form::textarea('description', $department->description, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('parent_id', 'Parent') !!}
                                        {!! Form::select('parent_id', $parents, $department->parent_id, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::label('notes', 'Notes') !!}
                                        {!! Form::textarea('notes', $department->notes, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('is_active', 'Active:', ['class' => 'col-md-2'])  !!}
                                        {!! Form::checkbox('is_active', 1, $department->is_active,['class' => 'col-md-2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
