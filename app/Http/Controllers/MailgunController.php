<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Message;
use App\Models\Retreat;
use App\Models\SsCustomForm;
use App\Models\SsCustomFormField;
use App\Models\SsContribution;
use App\Models\SsInventory;
use App\Models\SsOrder;
use App\Models\Touchpoint;
use App\Traits\MailgunTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Mailgun\Mailgun;


class MailgunController extends Controller
{   use MailgunTrait;
    public function __construct()
    {
        $this->middleware('auth');
        //dd(SystemController::is_mailgun_enabled());
        if (! SystemController::is_mailgun_enabled()) {
            Redirect('admin/config/mailgun')->send();
        }
    }

    /*
     * Get and processes stored mailgun emails 
     */
    public function get()
    {   // TODO: create database factories for mailgun/messages, squarespace order/donation
        // TODO: write unit tests for stripe, mailgun, squarespace order/donation controllers
        // TODO: when processing the full_address parts count the number of commas before exploding and ensure that there are no more than expected. Remove the first comma until we have the number expected.
        // TODO: for the moment, I'm going to be lazy and assume US as the country
        // TODO: room preference of None or Ninguna Preferencia (verify in SS) should be saved to the order as NULL
        // TODO: evaluate whether gift certificate retreat field is necessary in ss_order table or if it is better just to use the retreat field
        // TODO: for the address, attempt to normalize the state data (TX to Texas - may always be two state from squarespace - double check if that is the case)

        $this->authorize('admin-mailgun');

        $fail = Artisan::call('mailgun:get'); //because commands return 0 when successful the logic is somewhat reversed as 1 is failure and 0 is success
        if ($fail) {
            flash('Error: Mailgun messages were not successfully retrieved and processed. The site admin has been notified.')->error()->important();
        } else {
            flash('Success: Mailgun messages have been retrieved and processed.')->success()->important();
        }

        return Redirect::action([MailgunController::class, 'index']);
    }

    public function index() {
        // TODO: consider adding processed/unprocessed/all drowdown selector to filter results and combine processed and index blades into one
        $this->authorize('admin-mailgun');
        $messages = Message::whereIsProcessed(0)->orderBy('mailgun_timestamp','desc')->paginate(25, ['*'], 'messages');
        $messages_processed = Message::whereIsProcessed(1)->orderBy('mailgun_timestamp','desc')->paginate(25, ['*'], 'messages_processed');

        return view('mailgun.index', compact('messages','messages_processed'));
    }

    public function show($id) {

        $this->authorize('show-mailgun');

        $message = Message::with('contact_from','contact_to')->findOrFail($id);
        $body = explode("\n",$message->body);
        return view('mailgun.show', compact('message','body'));
    }

    public function edit($id) {

        $this->authorize('update-mailgun');

        // $message = Message::with('contact_from','contact_to')->findOrFail($id);
        // return view('mailgun.edit', compact('message'));
        return null;
    }

    public function unprocess($id) {

        $this->authorize('update-mailgun');
        $message = Message::findOrFail($id);
        $message->is_processed = 0;
        $message->save();

        // $message = Message::with('contact_from','contact_to')->findOrFail($id);
        // return view('mailgun.edit', compact('message'));
        return Redirect::action([self::class, 'show'],['mailgun'=>$id]);

    }

}
