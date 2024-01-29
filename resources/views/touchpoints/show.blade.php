@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                        @can('update-touchpoint')
                            <a href="{{url('touchpoint/'.$touchpoint->id.'/edit')}}">Touchpoint details</a> 
                        @else
                            Touchpoint details
                        @endCan
                        for {!!$touchpoint->person->contact_link_full_name!!}
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Date: </strong>{{$touchpoint->touched_at}}
                        <br /><strong>Contacted by: </strong>{{$touchpoint->staff->display_name}}  
                        <br /><strong>Type: </strong>{{$touchpoint->type}}     
                        <br /><strong>Notes: </strong>{{$touchpoint->notes}}
                    
                </div>
            </div></div>
            <div class='row'>
                @can('update-touchpoint')
                    <div class='col-md-1'>
                        <a href="{{ action([\App\Http\Controllers\TouchpointController::class, 'edit'], $touchpoint->id) }}" class="btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                    </div>
                @endCan
                @can('delete-touchpoint')
                    <div class='col-md-1'>
                        {{ html()->form('DELETE', route('touchpoint.destroy', [$touchpoint->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                        {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }} 
                        {{ html()->form()->close() }}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
    </div>
</section>
@stop