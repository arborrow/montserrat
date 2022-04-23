<?php

namespace App\Http\Controllers;

//require '\vendor\autoload.php';

use Mailgun\Mailgun;

class MailgunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //dd(SystemController::is_mailgun_enabled());
        if (! SystemController::is_mailgun_enabled()) {
            Redirect('admin/config/mailgun')->send();
        }
    }

    public function get()
    {
        $this->authorize('admin-mailgun');
        $message = new \Illuminate\Support\Collection;

        // $mg = new Mailgun(config('services.mailgun.secret'));
        $mg = Mailgun::create(config('services.mailgun.secret'));
        $domain = config('services.mailgun.domain');
        $queryString = ['event' => 'stored'];
        $events = $mg->events()->get("$domain", $queryString);
        // dd($events);
        $event_items = $events->getItems();

        if (isset($event_items)) {
            foreach ($event_items as $event_item) {

                $message_email = $mg->messages()->show($event_item->getStorage()['url']);
                // dd($event_item,$message_email);
                $message = \App\Models\Message::firstOrCreate(['mailgun_id'=>$event_item->getId()]);
                $message->mailgun_timestamp = \Carbon\Carbon::parse($event_item->getTimestamp());
                $message->storage_url = $event_item->getStorage()['url'];
                $message->subject = $message_email->getSubject();
                $message->body = $message_email->getBodyPlain();

                if (null !== $message_email->getSender()) {
                    $message->from = self::clean_email((string) $message_email->getSender());
                }
                if (null !== $message_email->getRecipients()) {
                    $message->recipients = self::clean_email((string) $message_email->getRecipients());
                }

                $headers = $event_item->getMessage()['headers'];

                if (null !== $headers['to']) {
                    $list_of_to_addresses = explode(',',$headers['to']);
                    // dd($headers, $headers['to'],$list_of_to_addresses);
                    // for now only take the first to address
                    $message->to = self::clean_email((string) $list_of_to_addresses[0]);
                }

                $contact_from = \App\Models\Contact::whereHas('groups', function ($query) {
                    $query->where('group_id', '=', config('polanco.group_id.staff'));
                })->whereHas('emails', function ($query) use ($message) {
                        $query->whereEmail($message->from);
                })->first();

                $contact_to = \App\Models\Contact::whereHas('emails', function ($query) use ($message) {
                    $query->whereEmail($message->to);
                })->first();

                $message->from_id = isset($contact_from->id) ? $contact_from->id : null;
                $message->to_id = isset($contact_to->id) ? $contact_to->id : null;

                $message->save();

            }
        }

        $messages = \App\Models\Message::orderBy('mailgun_timestamp','desc')->paginate(25, ['*'], 'messages');

        return view('mailgun.index', compact('messages'));
    }

    /*
     * Clean up the email address from Mailgun by removing <name>
     * No other cleaning of the email address is performed by this function
     * For example, Anthony Borrow<anthony.borrow@montserratretreat.org>
     * becomes anthony.borrow@montserratretreat.org
     * @param string|null $full_email
     *
     * returns string
     */

    public function clean_email($full_email = null)
    {
        $this->authorize('admin-mailgun');
        if (strpos($full_email, '<') && strpos($full_email, '>')) {
            return substr($full_email, strpos($full_email, '<') + 1, (strpos($full_email, '>') - strpos($full_email, '<')) - 1);
        } else {
            return $full_email;
        }
    }


    /*
     * extract value between two search strings from email body plain
     *
     * returns string of trimmed value
     */

    public function extract_value($body, $start_text = null, $end_text = null)
    {
        $this->authorize('admin-mailgun');
        $start_position = strpos($body, $start_text);
        $start_length = strlen($start_text);
        $end_position = strpos($body, $end_text);

        if ($end_position > $start_position) {
            return trim(substr($body, $start_position + $start_length, $end_position - $start_position - $start_length));
        } else {
            return null;
        }
    }


    /*
     * Processes stored mailgun emails after get which saves them to messages in db
     *
     */
    public function process()
    {
        $this->authorize('admin-mailgun');
        $messages = \App\Models\Message::whereIsProcessed(0)->get();

        foreach ($messages as $message) {

            // if we have from and to ids for contacts go ahead and create a touchpoint
            if (($message->from_id > 0) && ($message->to_id > 0) && (str_contains($message->recipients,'touchpoint'))) {
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Email';
                $touch->notes = $message->subject.' - '.$message->body;
                $touch->save();
                $message->is_processed=1;
                $message->save();
            }

            // if we have from and to ids for contacts go ahead and create a touchpoint
            if (str_contains($message->recipients,'registration')) {
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $donor_name = $this->extract_value($message->body, 'Donor Name:', 'Donor Email:');
                $donor_email = $this->extract_value($message->body, 'Donor Email:','Donor Address:');
                $donor_address = $this->extract_value($message->body, 'Donor Address:', 'Donor Phone Number:');
                $donor_address = preg_replace("/\r|\n/", " ", $donor_address);
                $donor_phone = $this->extract_value($message->body, 'Donor Phone Number:', 'Additional Information:');
                $type_of_offering = $this->extract_value($message->body, 'Type of Offering:','Retreat:');
                $retreat = $this->extract_value($message->body, 'Retreat:','Comments or Special Instruction:');
                $contribution = $this->extract_value($message->body, 'contribution of *','*!');

                dd($donor_name, $donor_email, $donor_address, $donor_phone,
                $type_of_offering, $retreat, $contribution, $message->body, $touch);

                $touch->notes = 'A donation from ' . $donor_name .
                    '(' . $donor_email. ') has been received.';

                $touch->save();
                $message->is_processed=1;
                $message->save();
            }

        }

        $messages = \App\Models\Message::whereIsProcessed(1)->get();
        //dd($messages);
        return view('mailgun.processed', compact('messages'));
    }

    public function index() {

        $this->authorize('show-mailgun');
        $messages = \App\Models\Message::orderBy('mailgun_timestamp','desc')->paginate(25, ['*'], 'messages');
        //dd($messages);
        return view('mailgun.index', compact('messages'));
    }

}
