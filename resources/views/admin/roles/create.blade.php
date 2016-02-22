@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Roles</strong></h2>
        {!! Form::open(['url' => 'admin/role', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('name', 'Name:', ['class' => 'col-md-3'])  !!}

                {!! Form::text('name', NULL , ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('display_name', 'Display Name:', ['class' => 'col-md-3'])  !!}

                {!! Form::text('display_name', NULL , ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('description', 'Description:', ['class' => 'col-md-3'])  !!}
                {!! Form::textarea('description', NULL, ['class' => 'col-md-3']) !!}                   
            </div>             

        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Role', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
    </span>
    </div>
</section>
@stop