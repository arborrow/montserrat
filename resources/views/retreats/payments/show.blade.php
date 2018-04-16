@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
                        
            <h2><strong><a href="{{url('retreat/'.$retreat->id.'/payments/edit')}}">Retreat Offerings</a> for <a href="{{url('retreat/'.$retreat->id)}}">{{$retreat->title}}</a></strong></h2>
             @if ($registrations->isEmpty())
                    <p> Bummer, there are no retreatants registered for this retreat </p>
                @else
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Retreatant</th>
                            <th>Deposit</th>
                            <th>Pledge</th>
                            <th>Paid</th>
                            <th>Terms</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations ->sortBy('retreatant.sort_name') as $registration)
                            <tr>
                            <td width="25%"><a href="{{url('person/'.$registration->retreatant->id)}}">{{ $registration->retreatant->sort_name}}</a></td>
                            <td width="10%"><a href="{{url('registration/'.$registration->id)}}">$ {{number_format($registration->deposit,2)}}</a></td>
                            <td width="10%">${!! $registration->donation_pledge_link !!}</a></td>
                            <td width="10%">$ {{ is_null($registration->donation) ? 0.00 : number_format($registration->donation->payments->sum('payment_amount'),2) }}</td>
                            <td width="25%"> {{ is_null($registration->donation) ? NULL : $registration->donation->terms }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>Totals: </td>
                            <td><strong>${{ number_format($registrations->sum('deposit'),2) }} *</strong></td>
                            <td><strong>${{ number_format($registrations->sum('donation_pledge'),2) }}</strong></td>
                            <td><strong>${{ number_format($registrations->sum('payment_paid'),2) }}</strong></td>
                            <td><strong>Total: ${{ number_format(($registrations->sum('deposit')+$registrations->sum('donation_pledge')),2)}} *</strong><br />
                            <strong>Retreatants: {{ count($registrations)}}</strong><br />
                            <strong>Average: ${{ number_format((($registrations->sum('deposit')+$registrations->sum('donation_pledge'))/count($registrations)),2) }} *</strong></td>
                            
                        </tr>
                    </tbody>
                </table>
                * Estimated deposits (data from registrations and thus not strictly financial)
                @endif
      
            
            
            
               
        </div>
    </section>
@stop