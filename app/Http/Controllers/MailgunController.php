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
        // dd($event_items);
        if (isset($event_items)) {
            foreach ($event_items as $event_item) {
                $event_date = $event_item->getEventDate();
                $process_date = \Carbon\Carbon::now()->subDays(2);

                if ($event_date > $process_date) { // mailgun stores messages for 3 days so only check for the last two days
                    try {
                        $message_email = $mg->messages()->show($event_item->getStorage()['url']);

                        $message = \App\Models\Message::firstOrCreate(['mailgun_id'=>$event_item->getId()]);
                        $message->mailgun_timestamp = \Carbon\Carbon::parse($event_item->getTimestamp());
                        $message->storage_url = $event_item->getStorage()['url'];
                        $message->subject = $message_email->getSubject();
                        $message->body = str_replace("\r\n","\n", $message_email->getBodyPlain());

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

                    } catch (\Exception $e) {
                        flash('Failed to retrieve Mailgun message: ' .$event_item->getId(). '. Error: '.$e->getMessage())->error()->important();
                    }


                }
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

    public function extract_value_between($body, $start_text = null, $end_text = null)
    {
        $this->authorize('admin-mailgun');

        $start_position = strpos($body, $start_text);
        $start_length = strlen($start_text);
        $end_position = strpos($body, $end_text, $start_position);

        if (($end_position > $start_position) && !$start_position === false) {
            return trim(substr($body, $start_position + $start_length, $end_position - $start_position - $start_length));
        } else {
            return null;
        }
    }


    /*
     * extract value beginning at search string until next new line
     *
     * returns string of trimmed value
     */

    public function extract_value($body, $start_text = null)
    {
        $this->authorize('admin-mailgun');
        $start_position = strpos($body, $start_text);
        $start_length = strlen($start_text);

        if ($start_position >= 0) {
            $end_position = strpos($body, "\n", $start_position + $start_length);
        }

        // TODO: consider while loop until next new line
        if (($end_position > $start_position) && !$start_position === false) {
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

            // #TOUCHPOINT - if this is a touchpoint
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

            // #DONATION REGISTRATION - if this is a donation payment for a retreat
            if (str_contains($message->recipients,'registration')) {
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $donor_name = $this->extract_value($message->body, "Donor Name:\n");
                $donor_email = $this->extract_value($message->body, "Donor Email:\n");
                $donor_address = $this->extract_value($message->body, "Donor Address:\n");
                $donor_address = preg_replace("\n/", " ", $donor_address);
                $donor_phone = $this->extract_value($message->body, "Donor Phone Number:\n");
                $type_of_offering = $this->extract_value($message->body, "Type of Offering:\n");
                $retreat = $this->extract_value($message->body, "Retreat:\n");
                $contribution = $this->extract_value_between($message->body, "contribution of *","*!");
                dd($donor_name, $donor_email, $donor_address, $donor_phone,
                $type_of_offering, $retreat, $contribution, $message->body, $touch);

                $touch->notes = 'A donation from ' . $donor_name .
                    '(' . $donor_email. ') has been received.';

                $touch->save();
                $message->is_processed=1;
                $message->save();
            }

            // #ORDER - if this is an order for a retreat
            if (str_contains($message->recipients,'order')) {
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $order = collect([]);

                $message_info = $this->extract_value_between($message->body, "SUBTOTAL", "Item Subtotal");
                $retreat = explode("\n",$message_info);

                $order->order_number = $this->extract_value_between($message->body, "Order #",".");
                $order->retreat_category=$retreat[0];
                $order->retreat_sku = $retreat[1];
                $order->retreat_description = trim(substr($retreat[2],0, strpos($retreat[2],"(")));
                $order->retreat_dates = substr($retreat[2], strpos($retreat[2],"(") + 1, strpos($retreat[2],")") - (strpos($retreat[2],"(") +1));

                // dd($year,$retreat_number,$idnumber,$event);
                //TODO: rather than trying to determine if the date in the message are in English or Spanish
                // get the year, retreat number and create the idnumber, lookup the event, and get the retreat start date from the actual event
                $year = substr($order->retreat_dates, strpos($order->retreat_dates,",") +2);
                $retreat_number = substr($order->retreat_description,
                    strpos($order->retreat_description, "#") + 1,
                    (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))
                );
                $idnumber = strval($year).$retreat_number;
                $event = \App\Models\Retreat::whereIdnumber($idnumber)->first();
                if (is_null($event)) {
                    $order->retreat_start_date = null;
                } else {
                    $order->retreat_start_date = $event->start_date;
                }

                $order->retreat_idnumber = $idnumber;
                $order->amount = $this->extract_value_between($message->body, "\nTOTAL", "$0.00");

                switch ($retreat[0]) {
                    case "Open Retreat (Men/Women/Couples)" :
                        $registration_type = explode("/",$retreat[3]);
                        $order->retreat_registration_type = trim($registration_type[0]);
                        $order->retreat_couple = trim($registration_type[1]);
                        break;
                    case "Women's Retreat" :
                        $registration_type = explode("/",$retreat[2]);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        break;
                    case "Men's Retreat" :
                        $registration_type = explode("/",$retreat[2]);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        break;
                    case "Registro para Retiros en Español" :
                        $registration_type = explode("/",$retreat[2]);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        $order->retreat_couple = trim($registration_type[2]);
                        break;
                }

                $inventory = \App\Models\SsInventory::whereName($order->retreat_category)->first();
                $custom_form = \App\Models\SsCustomForm::findOrFail($inventory->custom_form_id);
                $fields = \App\Models\SsCustomFormField::whereFormId($custom_form->id)->orderBy('sort_order')->get();
                $names = $fields->pluck('name')->toArray();
                foreach ($fields as $field) {
                    $extracted_value = $this->extract_value($message->body, $field->name.":\n");
                    $order->{$field->variable_name} = $extracted_value;

                    // to remove empty values where the extracted value is actually the name of the next field
                    // ideally I would think this would be done by extract_value but that would require passing $names to it each time
                    $field->search = array_search(str_replace(":","", $extracted_value),$names);
                    if ($field->search) {
                        $order->{$field->variable_name} = null;
                    }
                    // dd($message->body, $this->extract_value($message->body, $field->name.":\n"));
                }


                dd($order);

                // TODO: make sure full_address variable exists otherwise set order address parts to null
                $address = explode(", ", $order->full_address);
                $addr = collect([]);
                $addr->street = trim($address[0]);
                $addr->city = trim($address[1]);
                $address_detail = explode(" ", $address[2]);
                $addr->state = trim($address_detail[0]);
                $addr->zip = trim($address_detail[1]);
                $addr->country = (sizeof($address_detail) == 4) ? trim($address_detail[2]) . " " . trim($address_detail[3]) : trim($address_detail[2]);

                $order->address_street = $addr->street;
                $order->address_city = $addr->city;
                $order->address_state = $addr->state;
                $order->address_zip = $addr->zip;
                $order->address_country = $addr->country;

                dd($order, $retreat, $fields, $message->body);

                }

                // $touch->notes = 'Order #' . $order->order_number .' for #' . $order->idnumber . ' has been received.';

                // $touch->save();
                $message->is_processed=1;
                $message->save();
            }

        $messages = \App\Models\Message::whereIsProcessed(1)->get();
        return view('mailgun.processed', compact('messages'));
    }

    public function index() {

        $this->authorize('show-mailgun');
        $messages = \App\Models\Message::orderBy('mailgun_timestamp','desc')->paginate(25, ['*'], 'messages');
        //dd($messages);
        return view('mailgun.index', compact('messages'));
    }

}
