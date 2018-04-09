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
                            <th>Deposit</th>
                            <th>Description</th>
                            <th>Pledge</th>
                            <th>Paid</th>
                            <th>Method</th>
                            <th>Terms</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations ->sortBy('retreatant.sort_name') as $registration)
                            <tr>
                         
                        
                            <td width="20%"><a href="{{url('person/'.$registration->retreatant->id)}}">{{ $registration->retreatant->sort_name}}</a></td>
                            <td width="7%"> <a href="{{url('registration/'.$registration->id)}}">{{$registration->deposit}}</a></td>
                            <td width="20%">{!! Form::select('description['.$registration->id.']', $donation_description, 0) !!}</td>
                            <td width="7%"> {!! Form::number('pledge['.$registration->id.']', 0, ['id' => 'pledge['.$registration->id.']']) !!}</td>
                            <td width="7%"> {!! Form::number('paid['.$registration->id.']', 0, ['id' => 'paid['.$registration->id.']']) !!}</td>
                            <td width="15%">{!! Form::select('method['.$registration->id.']', $payment_description, 0) !!}</td>
                            <td width="20%"> {!! Form::text('terms['.$registration->id.']', null, ['id' => 'terms['.$registration->id.']']) !!}</td>
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