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
            // dd($message->mailgun_id, $message->body);
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
            //dd($message);

            // if this is a donation for a registration
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

            // if this is an order for a retreat

            if (str_contains($message->recipients,'order')) {
                $touch = new \App\Models\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Other';

                $order = collect([]);

                $retreat_info = $this->extract_value_between($message->body, "SUBTOTAL", "Salutation:");
                if (is_null($retreat_info)) {
                    $retreat_info = $this->extract_value_between($message->body, "SUBTOTAL", "Salutacion:");
                }
                $retreat = explode("\n",$retreat_info);
                if (strpos($retreat[0], "Retiros en Español") === false) {
                    // dd($retreat,strpos($retreat[0], "Retiros en Español") === false);
                    $order->order_number = $this->extract_value_between($message->body, "Order #",".");
                    $order->salutation = $this->extract_value($message->body, "Salutation:\n");
                    $order->name = $this->extract_value($message->body, "Name:\n");
                    $order->full_address = $this->extract_value($message->body, "Address:\n");
                    $order->phone_number = $this->extract_value($message->body, "Phone Number:\n");
                    $order->phone_type = $this->extract_value($message->body, "Phone Type:\n");
                    $order->email = $this->extract_value($message->body, "Email:\n");
                    $order->date_of_birth = $this->extract_value($message->body, "Date Of Birth:\n");
                    $order->emergency_contact = $this->extract_value($message->body, "Emergency Contact:\n");
                    $order->emergency_contact_relationship = $this->extract_value($message->body, "Emergency Contact Relationship:\n");
                    $order->emergency_contact_phone_number = $this->extract_value($message->body, "Emergency Contact Phone Number:\n");
                    $order->parish = $this->extract_value($message->body, "Parish:\n");
                    $order->primary_language = $this->extract_value($message->body, "Primary Language:\n");
                    $order->hear_about = $this->extract_value($message->body, "How did you hear about Montserrat?:\n");
                    $order->hear_other = $this->extract_value($message->body, "If \"Other\" please elaborate: :");
                    $order->hear_retreat = $this->extract_value($message->body, "How did you hear about this particular retreat?:\n");
                    $order->hear_ambassador = $this->extract_value($message->body, "If \"Retreat Ambassador\" please name them::");
                    $order->room_preference = $this->extract_value($message->body, "Room Preference:\n");
                    $order->dietary = $this->extract_value($message->body, "Dietary Restrictions, Food Allergies, or Other Special Needs::");
                    dd($order,$message->body, $message->id);
                    $order->comments = $this->extract_value($message->body, "Comments:");
                    $order->spouse_name = $this->extract_value($message->body, "Spouse's Name:\n");
                    $order->spouse_cell_phone = $this->extract_value($message->body, "Spouse's Cell Phone:\n");
                    $order->spouse_email = $this->extract_value($message->body, "Spouse's Email:\n");
                    $order->spouse_date_of_birth = $this->extract_value($message->body, "Spouse's Date of Birth:\n");
                    $order->spouse_emergency_contact = $this->extract_value($message->body, "Spouse's Emergency Contact:\n");
                    $order->spouse_emergency_contact_relationship = $this->extract_value($message->body, "Spouse's Emergency Contact Relationship:\n");
                    $order->spouse_emergency_contact_phone_number = $this->extract_value($message->body, "Spouse's Emergency Contact Phone Number:\n");
                    $order->spouse_dietary = $this->extract_value($message->body, "Spouse's Dietary Restrictions, Food Allergies, or Other Special Needs:");
                    $order->amount = $this->extract_value_between($message->body, "\nTOTAL", "$0.00");

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

                } else { // Spanish retreat

                    $order->order_number = $this->extract_value_between($message->body, "Order #",".");
                    $order->salutation = $this->extract_value($message->body, "Salutacion:\n");
                    $order->name = $this->extract_value($message->body, "Nombre/Apellido:\n");
                    $order->full_address = $this->extract_value($message->body, "Direccion:\n");
                    $order->phone_number = $this->extract_value($message->body, "Numero de Telefono de Casa:\n");
                    $order->phone_number_cell = $this->extract_value($message->body, "Numero de Telefono Movil:\n");
                    $order->phone_number_work = $this->extract_value_between($message->body, "Numero de Telefono de Trabajo:\n","Contacto de Emergencia:");
                    $order->phone_type = null;
                    $order->email = $this->extract_value($message->body, "Correo Electronico:\n");

                    $order->date_of_birth = $this->extract_value($message->body, "Fecha de Nacimiento:\n");
                    $order->emergency_contact = $this->extract_value($message->body, "Contacto de Emergencia:\n");
                    $order->emergency_contact_relationship = $this->extract_value($message->body, "Relacion a Contacto de Emergencia:\n");
                    $order->emergency_contact_phone_number = $this->extract_value($message->body, "Numero de Telefono de Contacto de Emergencia:\n");
                    $order->parish = $this->extract_value($message->body, "Parroquia:\n");
                    $order->primary_language = $this->extract_value($message->body, "Lenguage Primario:\n");
                    $order->hear_about = $this->extract_value($message->body, "¿Cómo se enteró de montserrat?:\n");
                    $order->hear_other = $this->extract_value($message->body, "Si otro, por favor elabora:");
                    $order->hear_retreat = $this->extract_value($message->body, "¿Cómo se enteró de este retiro en particular?:\n");
                    $order->hear_ambassador = $this->extract_value($message->body, "Si es Embajador del retiro, ¿nombre del Embajador?:");
                    $order->room_preference = $this->extract_value($message->body, "Preferencia de Habitación:\n");
                    $order->dietary = $this->extract_value($message->body, "Restricciones dietéticas, alergias a los alimentos u otras necesidades\nespeciales:\n");
                    $order->comments = $this->extract_value($message->body, "Comentarios:");

                    $order->spouse_salutation = $this->extract_value($message->body, "Salutacion del Conyuge:\n");
                    $order->spouse_name = $this->extract_value($message->body, "Nombre del Conyuge:\n");
                    $order->spouse_cell_phone = $this->extract_value_between($message->body, "Numero de Telefono del Conyuge:\n","Correo electronico del Conyuge");
                    $order->spouse_email = $this->extract_value_between($message->body, "Correo electronico del Conyuge:\n","Fecha de nacimiento del Conyuge");
                    $order->spouse_date_of_birth = $this->extract_value_between($message->body, "Fecha de nacimiento del Conyuge:\n","1\n");

                    $order->spouse_emergency_contact = null;
                    $order->spouse_emergency_contact_relationship = null;
                    $order->spouse_emergency_contact_phone_number = null;
                    $order->spouse_dietary = null;

                    $order->amount = $this->extract_value_between($message->body, "\nTOTAL", "$0.00");

                    $address = explode(", ", $order->full_address);
                    dd($order, $address, $message->body);
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

                }

                switch ($retreat[0]) {
                    case "Open Retreat (Men/Women/Couples)" :
                        $order->retreat_category=$retreat[0];
                        $order->retreat_sku = $retreat[1];
                        $order->retreat_description = trim(substr($retreat[2],0, strpos($retreat[2],"(")));

                        $retreat_dates = substr($retreat[2], strpos($retreat[2],"(") + 1, strpos($retreat[2],")") - (strpos($retreat[2],"(") +1));
                        $order->retreat_start_date = \Carbon\Carbon::parse(trim(substr($retreat_dates, 0, strpos($retreat_dates,"-"))) . substr($retreat_dates, strpos($retreat_dates,",")));
                        $order->retreat_idnumber = trim($order->retreat_start_date->year . substr($order->retreat_description, strpos($order->retreat_description, "#") + 1, (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))));
                        $registration_type = explode("/",$retreat[3]);
                        $order->retreat_registration_type = trim($registration_type[0]);
                        $order->retreat_couple = trim($registration_type[1]);
                        break;
                    case "Women's Retreat" :
                        $order->retreat_category=$retreat[0];
                        $order->retreat_sku = $retreat[1];
                        $order->retreat_description = trim(substr($retreat[2],0, strpos($retreat[2],"(")));

                        $retreat_dates = substr($retreat[2], strpos($retreat[2],"(") + 1, strpos($retreat[2],")") - (strpos($retreat[2],"(") +1));
                        $order->retreat_start_date = \Carbon\Carbon::parse(trim(substr($retreat_dates, 0, strpos($retreat_dates,"-"))) . substr($retreat_dates, strpos($retreat_dates,",")));
                        $order->retreat_idnumber = trim($order->retreat_start_date->year . substr($order->retreat_description, strpos($order->retreat_description, "#") + 1, (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))));
                        $registration_type = explode("/",$retreat[2]);
                        $order->retreat_registration_type = trim($registration_type[1]);

                        // dd($order, $retreat, $message->body, $message);
                        break;
                    case "Registro para Retiros en Español" :
                        $order->retreat_category=$retreat[0];
                        $order->retreat_sku = $retreat[1];
                        $order->retreat_description = trim(substr($retreat[2],0, strpos($retreat[2],"(")));

                        $retreat_dates = substr($retreat[2], strpos($retreat[2],"(") + 1, strpos($retreat[2],")") - (strpos($retreat[2],"(") +1));
                        $order->retreat_start_date = \Carbon\Carbon::parse(trim(substr($retreat_dates, 0, strpos($retreat_dates,"-"))) . substr($retreat_dates, strpos($retreat_dates,",")));
                        $order->retreat_idnumber = trim($order->retreat_start_date->year . substr($order->retreat_description, strpos($order->retreat_description, "#") + 1, (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))));
                        $registration_type = explode("/",$retreat[2]);
                        $order->retreat_registration_type = trim($registration_type[1]);
                        $order->retreat_couple = trim($registration_type[2]);

                        break;
                }

                dd($order, $retreat, $addr, $message->body, $message);

                $touch->notes = 'A donation from ' . $donor_name .
                    '(' . $donor_email. ') has been received.';

                $touch->save();
                $message->is_processed=1;
                $message->save();
            }

        }
        dd($messages);
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
