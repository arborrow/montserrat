<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Displays phpinfo.
     *
     * @return \Illuminate\Http\Response
     */
    public function phpinfo()
    {
	    phpinfo();
    }

    public static function is_twilio_enabled()
    {
	    if (NULL !==  env('TWILIO_SID') && NULL !== env('TWILIO_TOKEN')) {
                return TRUE;
            } else {
                return FALSE;
            }
    }
    public static function is_google_client_enabled()
    {
	    if (NULL !== env('GOOGLE_CLIENT_ID') && NULL !== env('GOOGLE_CLIENT_SECRET') && NULL !== env('GOOGLE_REDIRECT')) {
                return TRUE;
            } else {
                return FALSE;
            }
    }
    public static function is_mailgun_enabled()
    {
	    if (NULL !== env('MAILGUN_DOMAIN') && NULL !== env('MAILGUN_SECRET')) {
                return TRUE;
            } else {
                return FALSE;
            }
    }
    public function offeringdedup_index() {
        $this->authorize('show-offeringdedup');
        
        $offeringdedup =  \App\Offeringdedup::orderBy('count', 'desc')->paginate(50);
        // dd($dioceses);
        return view('offeringdedup.index', compact('offeringdedup'));
    }

    public function offeringdedup_show($contact_id = NULL, $event_id = NULL) {
        $this->authorize('show-offeringdedup');
        $donations = \App\Donation::whereEventId($event_id)->whereContactId($contact_id)->whereDonationDescription('Retreat Offering')->get();
        $combo = $contact_id.'-'.$event_id;
        return view('offeringdedup.show', compact('donations','combo'));
    }
}
