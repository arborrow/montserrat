@extends('template')
@section('content')
<h1>Welcome to the Montserrat Retreat House Database!</h1>
<p>This is the retreat page. You will be able to see a list of the retreats, create a retreat, update, a retreat and delete a retreat from this page.</p>
<p>
    <a href={{ route('retreat/index') }}>{!! Html::image('img/index.png', 'Index of Retreats',array('title'=>"Retreat Index")) !!}</a></li>
    <a href={{ route('retreat/index') }}>{!! Html::image('img/create.png', 'Create a Retreat',array('title'=>"Create Retreat")) !!}</a></li>
    <a href={{ route('retreat/index') }}>{!! Html::image('img/update.png', 'Update a Retreat',array('title'=>"Update Index")) !!}</a></li>
    <a href={{ route('retreat/index') }}>{!! Html::image('img/delete.png', 'Delete a Retreat',array('title'=>"Delete Retreat")) !!}</a></li>
</p>

@stop
