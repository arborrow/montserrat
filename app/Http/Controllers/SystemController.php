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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
