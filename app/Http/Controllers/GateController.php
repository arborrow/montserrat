<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-gate');
        $touchpoints = \App\Models\Touchpoint::whereType('Gate activity')->orderBy('touched_at', 'desc')->with('person', 'staff')->paginate(25);

        return view('gate.index', compact('touchpoints'));
    }

    public function open(Request $request, $hours = null)
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions

        $account_sid = config('settings.twilio_sid');
        $auth_token = config('settings.twilio_token');
        $twilio_number = config('settings.twilio_number');
        $to_number = config('settings.gate_number');

        if (isset($account_sid) && isset($auth_token) && isset($twilio_number) && isset($to_number)) {
            $message = 'Polanco is working to OPEN the gate (Gate settings configured).';
            $client = new Client($account_sid, $auth_token);
            try {
                if ($hours) {
                    $hours = sprintf('%02d', $hours);
                    $client->calls->create(
                        $to_number,
                        $twilio_number,
                        [
                        'sendDigits' => config('settings.open_hours_digits').$hours.config('settings.end_call_digits'),
                        'url' => 'http://demo.twilio.com/docs/voice.xml', ]
                    );
                } else {
                    $client->calls->create(
                        $to_number,
                        $twilio_number,
                        [
                        'sendDigits' => config('settings.open_digits').config('settings.end_call_digits'),
                        'url' => 'http://demo.twilio.com/docs/voice.xml', ]
                    );
                }
            } catch (\Exception $e) {
                report($e);
            }

            // create touchpoint to log open and closing of gate
            $text = ! isset($hours) ? null : ' for '.$hours.' hours';
            $current_user = $request->user();

            $touchpoint = new \App\Models\Touchpoint;
            $touchpoint->person_id = config('polanco.self.id');
            $touchpoint->staff_id = $current_user->contact_id;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->type = 'Gate activity';
            $touchpoint->notes = 'Request to open gate'.$text;
            $touchpoint->save();
        } else {
            $message = 'Gate settings are NOT sufficiently configured to OPEN the gate.';
        }

        return view('gate.open', compact('hours', 'message'));
    }

    public function close(Request $request)
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions

        $account_sid = config('settings.twilio_sid');
        $auth_token = config('settings.twilio_token');
        $twilio_number = config('settings.twilio_number');
        $to_number = config('settings.gate_number');
        // dd($account_sid, $auth_token, $twilio_number, $to_number);
        if (isset($account_sid) && isset($auth_token) && isset($twilio_number) && isset($to_number)) {
            $message = 'Polanco is working to CLOSE the gate (Gate settings configured).';
            $client = new Client($account_sid, $auth_token);
            try {
                $client->calls->create(
                    $to_number,
                    $twilio_number,
                    [
                'sendDigits' => config('settings.close_digits').config('settings.end_call_digits'),
                'url' => 'http://demo.twilio.com/docs/voice.xml', ]
                );
            } catch (\Exception $e) {
                report($e);
            }

            // create touchpoint to log open and closing of gate
            $text = ! isset($hours) ? null : ' for '.$hours.' hours';
            $current_user = $request->user();

            if (empty($current_user->contact_id)) {
                $defaults['user_id'] = config('polanco.self.id');
            } else {
                $defaults['user_id'] = $current_user->contact_id;
            }
            $touchpoint = new \App\Models\Touchpoint;
            $touchpoint->person_id = config('polanco.self.id');
            $touchpoint->staff_id = $current_user->contact_id;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->type = 'Gate activity';
            $touchpoint->notes = 'Request to close gate'.$text;
            $touchpoint->save();
        } else {
            $message = 'Gate settings are not sufficiently configured to CLOSE the gate.';
        }

        return view('gate.close', compact('message'));
    }
}
