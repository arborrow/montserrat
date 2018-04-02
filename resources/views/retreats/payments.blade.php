@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            {!! Form::open(['url' => 'retreat/payment_update', 'method' => 'POST', 'route' => ['retreat.payment_update', $retreat->id]]) !!}
        
            <h2><strong>Create Retreat Payments for {{$retreat->title}}</strong></h2>
             @if ($registrations->isEmpty())
                    <p> Bummer, there are no retreatants registered for this retreat </p>
                @else
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Retreatant</th>
                            <th>Description</th>
                            <th>Method</th>
                            <th>Pledge</th>
                            <th>Paid</th>
                            <th>Terms</th>
                            <th>ID</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Expire</th>
                            <th>Authorization</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations ->sortBy('retreatant.sort_name') as $registration)
                            <tr>
                            <td><a href="{{url('person/'.$registration->retreatant->id)}}">{{ $registration->retreatant->sort_name}}</a></td>
                            <td>{!! Form::select('description', $donation_description, 0, ['class' => 'col-md-3']) !!}</td>
                            <td>{!! Form::select('method', $payment_description, 0, ['class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::number('pledge', 0, ['id' => 'pledge', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::number('paid', 0, ['id' => 'paid', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('terms', null, ['id' => 'terms', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('id', null, ['id' => 'id', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('expire_date', null, ['id' => 'expire_date', 'class' => 'col-md-3']) !!}</td>
                            <td> {!! Form::text('authorization', null, ['id' => 'authorization', 'class' => 'col-md-3']) !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
<hr>           
            
            {!! Form::open(['url' => 'retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            
            
            
            <div class="col-md-2"><div class="form-group">
                {!! Form::submit('Submit retreat payments', ['class'=>'btn btn-primary']) !!}
            </div></div><div class="clearfix"> </div>
                {!! Form::close() !!}
        </div>
    </section>

@stop