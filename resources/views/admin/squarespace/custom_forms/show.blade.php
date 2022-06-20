@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-ss-custom-form')
            <h1>
                Squarespace Custom Form: <strong><a href="{{url('admin/squarespace/custom_form/'.$custom_form->id.'/edit')}}">{{ $custom_form->name }}</a></strong>
            </h1>
        @else
            <h1>
                Squarespace Custom Form: <strong>{{$custom_form->name}}</strong>
            </h1>
        @endCan
    </div>
    <table class="table table-striped table-bordered table-hover table-responsive-md">
    <thead>
        <caption>
            Custom form fields
            <span>
                @can('create-squarespace-custom-form')
                        <a href={{ action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'create_field'],$custom_form->id) }}>
                            {!! Html::image('images/create.png', 'Create Form Field',array('title'=>"Create Form Field",'class' => 'btn btn-light')) !!}
                        </a>
                @endCan
            </span>

        </caption>

        <th>Field name</th>
        <th>Type</th>
        <th>Variable name</th>
        <th>Sort order</th>
    </thead>
    <tbody>
    @foreach($custom_form->fields->sortBy('sort_order') as $field)
        <tr>
            <td><a href="{{ URL("admin/squarespace/custom_form_field/".$field->id."/edit") }}">{{ $field->name }}</a></td>
            <td>{{ $field->type }}</td>
            <td>{{ $field->variable_name }}</td>
            <td>{{ $field->sort_order }}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
    <div class="col-lg-12 mb-4">
        @can('update-ss-custom-form')
            <a href="{{ action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'edit'], $custom_form->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>

        @endcan
        @can('delete-ss-custom-form')
                {!! Form::open(['method' => 'DELETE', 'route' => ['custom_form.destroy', $custom_form->id], 'onsubmit'=>'return ConfirmDelete()', 'class' => 'd-inline']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}

        @endcan

    </div>
</div>
@stop
