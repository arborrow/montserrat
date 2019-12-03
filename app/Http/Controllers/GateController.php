<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function open($hours = null)
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions

        $account_sid = config('settings.twilio_sid');
        $auth_token = config('settings.twilio_token');
        $twilio_number = config('settings.twilio_number');
        $to_number = config('settings.gate_number');
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

        return view('gate.open', compact('hours'));
    }

    public function close()
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions

        $account_sid = config('settings.twilio_sid');
        $auth_token = config('settings.twilio_token');
        $twilio_number = config('settings.twilio_number');
        $to_number = config('settings.gate_number');
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

        return view('gate.close');
    }
}
