<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
 class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function open($hours = NULL)
    {   
        $this->authorize('show-gate'); // Check to see if the user has permissions
        
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');
        $to_number = env('GATE_NUMBER');
        $client = new Client($account_sid, $auth_token);
        try {
            if ($hours) {
                $hours = sprintf("%02d", $hours);
                $client->calls->create(  
                $to_number,
                $twilio_number,
                array(
                    'sendDigits' => env('OPEN_HOURS_DIGITS').$hours.env('END_CALL_DIGITS'),
                    'url' => "http://demo.twilio.com/docs/voice.xml")
                );
            } else {
                $client->calls->create(  
                $to_number,
                $twilio_number,
                array(
                    'sendDigits' => env('OPEN_DIGITS').env('END_CALL_DIGITS'),
                    'url' => "http://demo.twilio.com/docs/voice.xml")
                );
            }
        } catch (Exception $e) {
            report($e);
        }

        return view('gate.open', compact('hours'));
    }
     public function close()
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions
        
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');
        $to_number = env('GATE_NUMBER');
        $client = new Client($account_sid, $auth_token);
        try {
            $client->calls->create(
            $to_number,
            $twilio_number,
            array(
            'sendDigits' => env('CLOSE_DIGITS').env('END_CALL_DIGITS'),
            'url' => "http://demo.twilio.com/docs/voice.xml")
            );
        } catch (Exception $e) {
            report($e);
        }
        return view('gate.close');
  }
}