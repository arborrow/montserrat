@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            {{ html()->form('POST', route('retreat.payments.update', ))->open() }}
            {{ html()->hidden('event_id', $retreat->id) }}
                        
            <h2><strong>Retreat Offerings for {{$retreat->title}}</strong></h2>
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
                            <th>Method</th>
                            <th>CC/Chk Number</th>
                            <th>Terms</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations ->sortBy('retreatant.sort_name') as $registration)
                            <tr>
                        {{ html()->hidden('event_id', $retreat->id) }}
                        {{ html()->hidden('donations[' . $registration->id . '][id]', $registration->id) }}
                            <td width="25%"><a href="{{url('person/'.$registration->retreatant->id)}}">{{ $registration->retreatant->sort_name}}</a></td>
                            <td width="10%"> <a href="{{url('registration/'.$registration->id)}}">{{$registration->deposit}}</a></td>
                            <td width="10%"> {{ html()->number('donations[' . $registration->id . '][pledge]', is_null($registration->donation) ? 0 : $registration->donation->donation_amount)->id('pledge[' . $registration->id . ']')->attribute('step', '0.01') }}</td>
                            <td width="10%"> {{ html()->number('donations[' . $registration->id . '][paid]', is_null($registration->donation) ? 0 : $registration->donation->retreat_offering->payment_amount)->id('paid[' . $registration->id . ']')->attribute('step', '0.01') }}</td>
                            <td width="15%">{{ html()->select('donations[' . $registration->id . '][method]', $payment_description, is_null($registration->donation) ? 'Unassigned' : $registration->donation->retreat_offering->payment_description)->id('method[' . $registration->id . ']') }}</td>
                            <td width="5%"> {{ html()->number('donations[' . $registration->id . '][idnumber]', is_null($registration->donation) ? 0 : $registration->donation->retreat_offering->payment_number)->id('idnumber[' . $registration->id . ']') }}</td>
                            <td width="25%"> {{ html()->text('donations[' . $registration->id . '][terms]', is_null($registration->donation) ? NULL : $registration->donation->terms)->id('terms[' . $registration->id . ']') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>Totals: </td>
                            <td><strong>${{ number_format($registrations->sum('deposit'),2) }} *</strong></td>
                            <td><strong>${{ number_format($registrations->sum('donation_pledge'),2) }}</strong></td>
                            <td><strong>${{ number_format($registrations->sum('payment_paid'),2) }}</strong></td>
                            <td><strong>Total: ${{ number_format(($registrations->sum('deposit')+$registrations->sum('donation_pledge')),2)}} *</strong></td>
                            <td><strong>Retreatants: {{ count($registrations)}}</strong></td>
                            <td><strong>Average: ${{ number_format((($registrations->sum('deposit')+$registrations->sum('donation_pledge'))/count($registrations)),2) }} *</td>
                            
                        </tr>
                    </tbody>
                </table>
                * Estimated deposits (data from registrations and thus not strictly financial)
                @endif
<hr>           
            
            
            
            <div class="col-md-2"><div class="form-group">
                {{ html()->submit('Submit retreat payments')->class('btn btn-primary') }}
            </div></div><div class="clearfix"> </div>
                {{ html()->form()->close() }}
        </div>
    </section>

@stop