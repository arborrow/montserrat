<?php

namespace App\Http\Controllers;

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
                            $message->from = self::clean_email($message_email->getSender());
                        }
                        if (null !== $message_email->getRecipients()) {
                            $message->recipients = self::clean_email($message_email->getRecipients());
                        }

                        $headers = $event_item->getMessage()['headers'];

                        if (null !== $headers['to']) {
                            $list_of_to_addresses = explode(',',$headers['to']);
                            // dd($headers, $headers['to'],$list_of_to_addresses);
                            // for now only take the first to address
                            $message->to = self::clean_email($list_of_to_addresses[0]);
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
    {   // TODO: add various permissions for mailgun/messages to database seeder
        // TODO: ensure that we validate who the mail is coming from - create environmental variable of array of acceptable senders
        // TODO: update database seeder for prefix table
        // TODO: write unit tests for stripe and mailgun functionality

        $this->authorize('admin-mailgun');
        $messages = \App\Models\Message::whereIsProcessed(0)->get();

        foreach ($messages as $message) {
            // #TOUCHPOINT - if this is a touchpoint
            // if we have from and to ids for contacts go ahead and create a touchpoint
            // TODO: validate that from is from enforced domain (if applicable)

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
            if (str_contains($message->recipients,'donation')) {
                // TODO: create touchpoint indicating that the user made a donation
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $ss_donation = \App\Models\SsDonation::firstOrCreate([
                    'message_id' => $message->id,
                ]);

                $donation = explode("\n",$message->body);
                $donation = array_values(array_filter($donation));
                $address_start_row = array_search("Donor Address:",$donation);
                $address_end_row = array_search("Donor Phone Number:",$donation);
                // dd($donation,$address_start_row, $address_end_row);
                if (($address_end_row - $address_start_row) == 5) {
                    $ss_donation->address_street = ucwords(strtolower($donation[$address_start_row+1]));
                    $ss_donation->address_street_2 = ucwords(strtolower($donation[$address_start_row+2]));
                    $address_details = explode(",",$donation[$address_start_row+3]);
                } else {
                    $ss_donation->address_street = ucwords(strtolower($donation[$address_start_row+1]));
                    $address_details = explode(",",$donation[$address_start_row+2]);
                }

                $ss_donation->address_city = ucwords(strtolower(trim($address_details[0])));
                $ss_donation->address_state = trim($address_details[1]);
                $ss_donation->address_zip = trim($address_details[2]);
                $ss_donation->address_country = ucwords($donation[$address_end_row-1]);
                $ss_donation->message_id = $message->id;
                $ss_donation->name = ucwords(strtolower($this->extract_value($message->body, "Donor Name:\n")));
                $ss_donation->email = strtolower($this->extract_value($message->body, "Donor Email:\n"));
                $ss_donation->phone = $this->extract_value($message->body, "Donor Phone Number:\n");
                $ss_donation->offering_type = $this->extract_value($message->body, "Type of Offering:\n");
                $ss_donation->retreat_description = $this->extract_value($message->body, "Retreat:\n");
                $ss_donation->amount = $this->extract_value_between($message->body, "contribution of *$","*!");
                $ss_donation->comments = trim($this->extract_value_between($message->body, "Comments or Special Instructions:\n","View My Donations\n"));
                $ss_donation->fund = $this->extract_value($message->body, "Please Select a Fund:\n");
                $year = substr($ss_donation->retreat_description, -5, 4);
                $retreat_number = trim(substr($ss_donation->retreat_description,
                    strpos($ss_donation->retreat_description, "#") + 1,
                    (strpos($ss_donation->retreat_description, " ") - strpos($ss_donation->retreat_description, "#"))
                ));
                $ss_donation->idnumber = ($ss_donation->retreat_description == "Individual Private Retreat") ? null : trim($year.$retreat_number);
                $event = \App\Models\Retreat::whereIdnumber($ss_donation->idnumber)->first();
                $ss_donation->event_id = optional($event)->id;
                $ss_donation->comments = ($ss_donation->comments == 1) ? null : $ss_donation->comments;
                $ss_donation->save();
                // $touch->notes = 'A donation from ' . $donor_name .  '(' . $donor_email. ') has been received.';
                //$touch->save();
                // dd($ss_donation, $message->body);

            }

            // #ORDER - if this is an order for a retreat
            if (str_contains($message->recipients,'order')) {
                // TODO: create touchpoint that user registered for a retreat via the website
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $order_number = $this->extract_value_between($message->body, "Order #",".");

                $order = \App\Models\SsOrder::firstOrCreate([
                    'order_number' => $order_number,
                ]);

                $order->message_id = $message->id;
                $message_info = $this->extract_value_between($message->body, "SUBTOTAL", "Item Subtotal");

                $retreat = explode("\n",$message_info);
                $order->retreat_category=$retreat[0];

                $inventory = \App\Models\SsInventory::whereName($order->retreat_category)->first();
                $custom_form = \App\Models\SsCustomForm::findOrFail($inventory->custom_form_id);
                $fields = \App\Models\SsCustomFormField::whereFormId($custom_form->id)->orderBy('sort_order')->get();

                // TODO: for now this is limited to two line; however, some refactoring could make this more dynamic with a while loop
                if ($inventory->variant_options > 1) { // all variant options not on one line, so concatenante with next line
                    if (substr_count($retreat[2], " / ") < $inventory->variant_options) {
                        $product_variation = trim($retreat[2]) . ' ' . trim($retreat[3]);
                    } else {
                        $product_variation = trim($retreat[2]);
                    }
                } else {
                    $product_variation = trim($retreat[2]);
                }

                $order->retreat_sku = $retreat[1];
                $order->retreat_description = trim(substr($product_variation,0, strpos($product_variation,"(")));
                $order->retreat_dates = substr($product_variation, strpos($product_variation,"(") + 1, strpos($product_variation,")") - (strpos($product_variation,"(") +1));

                // dd($year,$retreat_number,$idnumber,$event);
                //TODO: rather than trying to determine if the date in the message are in English or Spanish
                // get the year, retreat number and create the idnumber, lookup the event, and get the retreat start date from the actual event
                $year = substr($order->retreat_dates, strpos($order->retreat_dates,", ") +2);

                $retreat_number = substr($order->retreat_description,
                    strpos($order->retreat_description, "#") + 1,
                    (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))
                );

                $idnumber = trim(strval($year).$retreat_number);
                $order->retreat_idnumber = $idnumber;
                $event = \App\Models\Retreat::whereIdnumber($idnumber)->first();
                $order->retreat_start_date = optional($event)->start_date;
                $order->event_id = optional($event)->id;

                $order->deposit_amount = str_replace("$","",$this->extract_value_between($message->body, "\nTOTAL", "$0.00"));
                switch ($order->retreat_category) {
                    case "Open Retreat (Men, Women, and Couples)" :
                        $registration_type = explode(" / ", $product_variation);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        $order->retreat_couple = trim($registration_type[2]);
                        break;
                    case "Women's Retreat" :
                        $registration_type = explode(" / ",$product_variation);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        break;
                    case "Men's Retreat" :
                        $registration_type = explode(" / ",$product_variation);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        break;
                    case "Registro para Retiros en Español" :
                        $registration_type = explode(" / ", $product_variation);
                        $retreat_number = substr($order->retreat_description,
                            strpos($order->retreat_description, "#") + 1,
                            (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))
                        );

                        // dd($order,$retreat,$registration_type,$product_variation, $message->body);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        $order->retreat_couple = trim($registration_type[2]);
                        break;
                    case "Special Event - Man In The Ditch" :
                        $idnumber='20220618';
                        $order->retreat_idnumber = '20220618'; // hardcoded
                        $order->retreat_dates = 'June 18, 2022';
                        $event = \App\Models\Retreat::whereIdnumber($idnumber)->first();
                        $order->retreat_start_date = optional($event)->start_date;
                        $order->event_id = optional($event)->id;
                        $order->retreat_description=$order->retreat_category;

                    break;

                }

                //dd($order,$retreat);
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

                // TODO: make sure full_address variable exists otherwise set order address parts to null
                $address = explode(", ", $order->full_address);
                if (sizeof($address) == 4) {
                    $order->address_street = trim($address[0]);
                    $order->address_street_2 = trim($address[1]);
                    $order->address_city = trim($address[2]);
                    $address_detail = explode(" ", $address[3]);

                } else { // assumes size of 3
                    $order->address_street = trim($address[0]);
                    $order->address_city = trim($address[1]);
                    $address_detail = explode(" ", $address[2]);
                }
                $order->address_state = trim($address_detail[0]);
                $order->address_zip = trim($address_detail[1]);
                $order->address_country = (sizeof($address_detail) == 4) ? trim($address_detail[2]) . " " . trim($address_detail[3]) : trim($address_detail[2]);

                // dd($message->body, $order, $address,$address_detail);
                $order->comments = ($order->comments == 1) ? null : $order->comments;
                $order->couple_date_of_birth = ($order->couple_date_of_birth == 1) ? null : $order->couple_date_of_birth;
                $order->save();

                }

            // $touch->notes = 'Order #' . $order->order_number .' for #' . $order->idnumber . ' has been received.';

            // $touch->save();
            $message->is_processed=1;
            if (isset($order)) {
                $message->save();
                // dd($order, $retreat, $message->body);
            }
            if (isset($ss_donation)) {
                $message->save();
                // dd($ss_donation, $message->body,);
            }

            // dd($message->body, 'Hmm, neither order or donation!', $message);

            /*
            gift_certificate_number
            purchaser_title (use title)
            purchaser_name (use name )
            purchaser_address (use full_address)
            purchaser_email (use email )
            purchaser_mobile_phone (use mobile_phone)
            purchaser_home_phone (use home_phone)
            purchaser_work_phone (use work_phone)
            recipient_email (use couple_email)
            recipient_name (use couple_name)
            recipient_phone (use couple_mobile_phone)
            */

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

    public function show($id) {

        $this->authorize('show-mailgun');

        $message = \App\Models\Message::with('contact_from','contact_to')->findOrFail($id);
        return view('mailgun.show', compact('message'));
    }

    public function edit($id) {

        $this->authorize('update-mailgun');

        // $message = \App\Models\Message::with('contact_from','contact_to')->findOrFail($id);
        // return view('mailgun.edit', compact('message'));
        return null;
    }

}
