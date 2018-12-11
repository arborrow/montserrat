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
        $to_number = '+14693484531'; // +19404972989
        $client = new Client($account_sid, $auth_token);
        try {
            if ($hours) {
                $hours = sprintf("%02d", $hours);
                $client->calls->create(  
                $to_number,
                $twilio_number,
                array(
                    'sendDigits' => "ww1#ww001540#ww80#".$hours."#ww99#",
                    'url' => "http://demo.twilio.com/docs/voice.xml")
                );
            } else {
                $client->calls->create(  
                $to_number,
                $twilio_number,
                array(
                    'sendDigits' => "ww1#ww001540#ww81#ww99#",
                    'url' => "http://demo.twilio.com/docs/voice.xml")
                );
            }
        } catch (Exception $e) {
            report($e);
        }
        dd('Open gate call: '.$to_number, $client);
    }

    public function close()
    {
        $this->authorize('show-gate'); // Check to see if the user has permissions
        
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');
        $to_number = "+14693484531";
        $client = new Client($account_sid, $auth_token);
        try {
            $client->calls->create(  
            $to_number,
            $twilio_number,
            array(
            'sendDigits' => "ww1#ww001540#ww83#ww99#",
            'url' => "http://demo.twilio.com/docs/voice.xml")
            );
        } catch (Exception $e) {
            report($e);
        }
        dd('Close gate call: '.$to_number, $client);
  }
}