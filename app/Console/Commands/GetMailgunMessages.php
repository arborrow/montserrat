<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\Message;
use App\Models\Retreat;
use App\Models\SquarespaceContribution;
use App\Models\SquarespaceCustomForm;
use App\Models\SquarespaceCustomFormField;
use App\Models\SquarespaceInventory;
use App\Models\SquarespaceOrder;
use App\Traits\MailgunTrait;
use App\Models\Touchpoint;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Mailgun\Mailgun;


class GetMailgunMessages extends Command
{

    use MailgunTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailgun:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve stored events (messages) from Mailgun';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = new \Illuminate\Support\Collection;
        $username = 'Polanco';
        $ip_address = "45.79.24.203";
        $fullurl = "https://polanco.montserratretreat.org/";
        $subject = "Error Retrieving Mailgun Messages";

        $mg = Mailgun::create(config('services.mailgun.secret'));
        $domain = config('services.mailgun.domain');
        $queryString = ['event' => 'stored'];
        $events = $mg->events()->get("$domain", $queryString);
        $event_items = $events->getItems();
        
        if (isset($event_items)) {
            foreach ($event_items as $event_item) {
                $event_date = $event_item->getEventDate();
                $process_date = Carbon::now()->subDays(2);
                // dd($event_item->getStorage()['url']);
                if ($event_date > $process_date) { // mailgun stores messages for 3 days so only check for the last two days
                    try {
		        $mailgun_url = $event_item->getStorage()['url'];
  		        $message_email = $mg->messages()->show($event_item->getStorage()['url']);
                        $sender = $message_email->getSender();
                        if (strpos($sender,config('polanco.socialite_domain_restriction')) >= 0) { // block emails from outside domains

                            $message = Message::firstOrCreate(['mailgun_id'=>$event_item->getId()]);
                            $message->mailgun_timestamp = Carbon::parse($event_item->getTimestamp());
                            $message->storage_url = $event_item->getStorage()['url'];
                            $message->subject = $message_email->getSubject();
                            // $message->body = str_replace("\r\n","\n", html_entity_decode(strip_tags($message_email->getBodyHtml())));
                            $message->body = $message_email->getBodyHtml();

                            if (null !== $message_email->getSender()) {
                                $message->from = $this->clean_email($message_email->getSender());
                            }
                            if (null !== $message_email->getRecipients()) {
                                $message->recipients = $this->clean_email($message_email->getRecipients());
                            }
                            $headers = $event_item->getMessage()['headers'];

                            if (null !== $headers['to']) {
                                $list_of_to_addresses = explode(',',$headers['to']);
                                // dd($headers, $headers['to'],$list_of_to_addresses);
                                // for now only take the first to address
                                $message->to = $this->clean_email($list_of_to_addresses[0]);
                            }

                            $contact_from = Contact::whereHas('groups', function ($query) {
                                $query->where('group_id', '=', config('polanco.group_id.staff'));
                            })->whereHas('emails', function ($query) use ($message) {
                                    $query->whereEmail($message->from);
                            })->first();

                            $contact_to = Contact::whereHas('emails', function ($query) use ($message) {
                                $query->whereEmail($message->to);
                            })->first();

                            $message->from_id = isset($contact_from->id) ? $contact_from->id : null;
                            $message->to_id = isset($contact_to->id) ? $contact_to->id : null;
                            $message->save();
                            //dd($message);
                        }

                    } catch (\Exception $exception) {
                        Mail::send('emails.en_US.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address, 'subject' => $subject, 'mailgun_url' => $mailgun_url],
                        function ($m) use ($subject, $exception) {
                            $m->to(config('polanco.admin_email'))
                                ->subject('Error Retrieving Mailgun Messages');
                        });
                        return 1;
                    }
                }
            }
        }
        

        
        $messages = Message::whereIsProcessed(0)->get();

        // dd($messages);
        foreach ($messages as $message) {
            // #TOUCHPOINT - if this is a touchpoint
            // if we have from and to ids for contacts go ahead and create a touchpoint
            // TODO: validate that from is from enforced domain (if applicable)
            $clean_message = str_replace("\r\n","\n", html_entity_decode(strip_tags($message->body)));

            if (($message->from_id > 0) && ($message->to_id > 0) && (str_contains($message->recipients,'touchpoint'))) {
                try {
                    $touch = new Touchpoint();
                    $touch->person_id = $message->to_id;
                    $touch->staff_id = $message->from_id;
                    $touch->touched_at = $message->timestamp;
                    $touch->type = 'Email';
                    $touch->notes = $message->subject.' - '.$clean_message;
                    $touch->save();
                    $message->is_processed=1;
                    $message->save();
                } catch (\Exception $exception) {
                    $subject .= ': Creating Touchpoint for Message Id #'.$message->id;
                    Mail::send('emails.en_US.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address, 'subject' => $subject],
                    function ($m) use ($subject, $exception) {
                        $m->to(config('polanco.admin_email'))
                            ->subject('Error Retrieving Mailgun Messages');
                    });
                }
            }

            // #DONATION REGISTRATION - if this is a donation payment for a retreat
            if (str_contains($message->recipients,'donation')) {
                // TODO: create touchpoint indicating that the user made a donation
                try {
                    $touch = new Touchpoint();
                    $touch->person_id = $message->to_id;
                    $touch->staff_id = $message->from_id;
                    $touch->touched_at = $message->timestamp;
                    $touch->type = 'Other';

                    $ss_donation = SquarespaceContribution::firstOrCreate([
                        'message_id' => $message->id,
                    ]);

                    $donation = explode("\n",$clean_message);
                    $donation = array_map('trim',$donation);
                    $donation = array_values(array_filter($donation));
                    $address_start_row = array_search("Donor Address:",$donation);
                    $address_end_row = array_search("Donor Phone Number:",$donation);
                    if ($address_end_row === false) { // if the phone number is not provided
                        $address_end_row = array_search("Additional Information:",$donation);
                    }
                    if ($address_start_row > 0) { // if there is no address_start_row skip attempt to process address
                        // dd($donation,$address_start_row, $address_end_row);
                        if (($address_end_row - $address_start_row) == 5) {
                            $ss_donation->address_street = ucwords(strtolower($donation[$address_start_row+1]));
                            $ss_donation->address_supplemental = ucwords(strtolower($donation[$address_start_row+2]));
                            $address_details = explode(",",$donation[$address_start_row+3]);
                        } else {
                            $ss_donation->address_street = ucwords(strtolower($donation[$address_start_row+1]));
                            $address_details = explode(",",$donation[$address_start_row+2]);
                        }
                        $ss_donation->address_city = ucwords(strtolower(trim($address_details[0])));
                        $ss_donation->address_state = trim($address_details[1]);
                        $ss_donation->address_zip = trim($address_details[2]);
                        $ss_donation->address_country = ucwords($donation[$address_end_row-1]);    
                    }
                    
                    $ss_donation->message_id = $message->id;
                    
                    
                    $ss_donation->name = ucwords(strtolower($this->extract_data($donation, "Donor Name:")));
                    $ss_donation->email = strtolower($this->extract_data($donation, "Donor Email:"));
                    $ss_donation->phone = $this->extract_data($donation, "Donor Phone Number:");
                    $ss_donation->retreat_description = $this->extract_data($donation, "Retreat:");
                    
                    
                    // it seems some of the emails had * characters and some do not so we will check for both
                    $donation_amount = $this->extract_data($donation,'Donation Received');
                    $amount = substr($donation_amount, strpos($donation_amount,'$'),strpos($donation_amount,'!')-strpos($donation_amount,'$'));
                    $amount = str_replace('$','', $amount);
                    $amount = str_replace('!','', $amount);
                    $amount = str_replace('*','', $amount);
                    $ss_donation->amount = $amount;
                    
                    
                    $ss_donation->fund = $this->extract_data($donation, "Please Select a Fund:");
                    $year = substr($ss_donation->retreat_description, -5, 4);
                    
                    $retreat_number = trim(substr($ss_donation->retreat_description,
                        strpos($ss_donation->retreat_description, "#") + 1,
                        (strpos($ss_donation->retreat_description, " ") - strpos($ss_donation->retreat_description, "#"))
                    ));
                
                    
                    $ss_donation->idnumber = ($ss_donation->retreat_description == "Individual Private Retreat") ? null : trim($year.$retreat_number);
                    $ss_donation->comments = trim($this->extract_data($donation, "Comments or Special Instructions:"));
                    $ss_donation->comments = str_replace('View My Donations','',$ss_donation->comments);
                    
                    $event = Retreat::whereIdnumber($ss_donation->idnumber)->first();
                    $ss_donation->event_id = optional($event)->id;
                    
                    if (isset($ss_donation->idnumber) && isset($ss_donation->event_id)) { // if a particular event then based on end date of event if passed retreat funding, if upcoming then deposit
                        $ss_donation->offering_type = ($event->end_date > now()) ? 'Pre-Retreat offering' : 'Post-Retreat offering';
                    }  
                    
                    
                    switch ($ss_donation->retreat_description) {
                        case 'Saturday of Renewal' : // if SOR then assume SOR has passed so post-retreat
                            $ss_donation->offering_type = 'Post-Retreat offering';
                            break;
                        case 'Individual Private Retreat' : // if Individual Private Retreat assume retreat deposit
                            $ss_donation->offering_type = 'Pre-Retreat offering';
                            break;
                        default :
                    }
                    // dd($donation, $ss_donation);    
                    $ss_donation->save();

                } catch (\Exception $exception) {
                    $subject .= ': Creating Squarespace Contribution for Message Id #'.$message->id;
                    dd($exception, $subject);
                    Mail::send('emails.en_US.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address, 'subject' => $subject],
                    function ($m) use ($subject, $exception) {
                        $m->to(config('polanco.admin_email'))
                            ->subject('Error Retrieving Mailgun Messages');
                    });
                }
            }

            // #ORDER - if this is an order for a retreat
            if (str_contains($message->recipients,'order')) {
                try {
                    $order_number = $this->extract_value_between($clean_message, "Order #",".");
                    $order_date = $this->extract_value_between($clean_message, "Placed on","CT. View in Stripe");
                    $order = SquarespaceOrder::firstOrCreate([
                        'order_number' => $order_number,
                    ]);

                    $order->order_number = $order_number;
                    $order->message_id = $message->id;
                    $order->created_at = (isset($order_date)) ? Carbon::parse($order_date) : Carbon::now();
                    
                    $message_info = $this->extract_value_between($clean_message, "SUBTOTAL", "Item Subtotal");
                    
                    $retreat = array_values(array_filter(explode("\n",$message_info)));
                    $retreat = array_map('trim',$retreat);
                    // remove blank lines
                    $retreat = array_filter($retreat);
                    // remove line with only a space in it that was not removed from the trim above, grrr
                    $retreat = array_filter($retreat, function($value) { return $value !== "\xC2\xA0"; });
                    // rekey the array
                    $retreat = array_values($retreat);
                    
                    $order->retreat_category= (array_key_exists(0,$retreat)) ? $retreat[0] : null;
                    $order->retreat_sku = (array_key_exists(1,$retreat)) ? $retreat[1] : null;
                    
                    // TODO:: in order for test to pass, we need to have better/more functional seed and factory generated data
                    $inventory = SquarespaceInventory::whereName($order->retreat_category)->first();
                    $custom_form = SquarespaceCustomForm::findOrFail($inventory->custom_form_id);
                    $fields = SquarespaceCustomFormField::whereFormId($custom_form->id)->orderBy('sort_order')->get();
                    
                    
                    $first_field_position = array_search($fields[0]->name.":", $retreat);
                    $product_variation="";
                    for ($i=2; $i<=$first_field_position-1; $i++) {
                        $product_variation = $product_variation . $retreat[$i] . ' ';
                    }

                    $order->retreat_description = trim(substr($product_variation,0, strpos($product_variation,"(")));
                    $order->retreat_dates = substr($product_variation, strpos($product_variation,"(") + 1, strpos($product_variation,")") - (strpos($product_variation,"(") +1));

                    //TODO: rather than trying to determine if the date in the message are in English or Spanish
                    // get the year, retreat number and create the idnumber, lookup the event, and get the retreat start date from the actual event
                    $year = substr($order->retreat_dates, strpos($order->retreat_dates,", ") +2);

                    $retreat_number = substr($order->retreat_description,
                        strpos($order->retreat_description, "#") + 1,
                        (strpos($order->retreat_description, " ") - strpos($order->retreat_description, "#"))
                    );

                    $idnumber = trim(strval($year).$retreat_number);
                    $order->retreat_idnumber = $idnumber;
                    $event = Retreat::whereIdnumber($idnumber)->first();
                    
                    $order->retreat_start_date = optional($event)->start_date;
                    $order->event_id = optional($event)->id;

                    //$order->deposit_amount = str_replace("$","",$this->extract_value_between($message->body, "\nTOTAL", "$0.00"));
                    // a bit hacky but TOTAL was being flakey possibly because of SUBTOTAL so Tax was more unique
                    $deposit_amount = str_replace("$","",trim(str_replace("TOTAL","",$this->extract_value_between($clean_message, "Tax\n", "$0.00"))));
                    $deposit_amount = array_values(array_filter(explode("\n",$deposit_amount)));
                    $deposit_amount = array_map('trim',$deposit_amount);
                    // remove blank lines
                    $deposit_amount = array_filter($deposit_amount);
                    // remove line with only a space in it that was not removed from the trim above, grrr
                    $deposit_amount = array_filter($deposit_amount, function($value) { return $value !== "\xC2\xA0"; });
                    // rekey the array
                    $deposit_amount = array_values($deposit_amount);
                    

                    $order->deposit_amount = $deposit_amount[0];
                    
                    $quantity = $retreat[sizeof($retreat)-3];
                    $unit_price=str_replace("$", "", $retreat[sizeof($retreat)-2]);
                    $order->retreat_quantity = isset($quantity) ? $quantity : 0;
                    $order->unit_price = isset($unit_price) ? $unit_price : 0;
                    $registration_type = explode(" / ", $product_variation);
                    if (isset($registration_type[1])) {
                        $order->retreat_registration_type = trim($registration_type[1]);
                    }
                            
                    switch ($order->retreat_category) {
                        case "Open Retreat (Men, Women, and Couples)" :
                            $order->retreat_couple = trim($registration_type[2]);
                            break;
                        case "Retiro en Español" :
                            $order->retreat_couple = trim($registration_type[2]);
                            break;
                        case "Couple's Retreat" :
                                $order->retreat_couple = 'Couple';
                                break;
                        case "Special Event - Man In The Ditch" :
                            $idnumber='20220618';
                            $order->retreat_idnumber = '20220618'; // hardcoded
                            $order->retreat_dates = 'June 18, 2022';
                            $event = Retreat::whereIdnumber($idnumber)->first();
                            $order->retreat_start_date = optional($event)->start_date;
                            $order->event_id = optional($event)->id;
                            $order->retreat_registration_type = 'Registration and Deposit';
                            $order->retreat_description=$order->retreat_category;
                            break;
                        default : //  "Women's Retreat", "Men's Retreat", "Young Adult's Retreat"
                            break;
                    }
    
                    
                    // dd($order, $retreat, $registration_type, $message->body,str_replace("$","",trim(str_replace("TOTAL","",$this->extract_value_between($message->body, "Tax\n", "$0.00")))));
                    $names = $fields->pluck('name')->toArray();
                    //dd($order,$product_variation,$registration_type, $fields,$inventory);    
                    foreach ($fields as $field) {          
                        $extracted_value = $this->extract_data($retreat, $field->name.":");
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
                    // TODO: get the billing address and compare to address provided, different billing address may indicate someone else is paying for the retreat
                    // TODO: consider comparing extract_value and extract_value_between to better deal with multiple line addresses
                    if (isset($order->full_address)) {
                        $address = explode(", ", $order->full_address);

                        if (sizeof($address) == 4) {
                            $order->address_street = trim($address[0]);
                            $order->address_supplemental = trim($address[1]);
                            $order->address_city = trim($address[2]);
                            $address_detail = explode(" ", $address[3]);
                            $order->address_state = trim($address_detail[0]);
                            $order->address_zip = trim($address_detail[1]);
                            $order->address_country = (sizeof($address_detail) == 4) ? trim($address_detail[2]) . " " . trim($address_detail[3]) : trim($address_detail[2]);            
                        } 

                        if (sizeof($address) == 3) {
                            $order->address_street = trim($address[0]);
                            $order->address_city = trim($address[1]);
                            $address_detail = explode(" ", $address[2]);
                        }

                        if (isset($address_detail)) {

                            $order->address_state = trim($address_detail[0]);
                            $order->address_zip = trim($address_detail[1]);

                            if (sizeof($address_detail) == 3) {
                                $order->address_country = trim($address_detail[2]);   
                            }
                            
                            if (sizeof($address_detail) == 4) {
                                $order->address_country = trim($address_detail[2]) . " " . trim($address_detail[3]);   
                            }
                        }
                    } else { 
                        // something is wrong with the address - leave it as null
                    }

                    $order->comments = ($order->comments == 1) ? null : $order->comments;
                    $order->date_of_birth = ($order->date_of_birth == 1) ? null : $order->date_of_birth;
                    $order->couple_date_of_birth = ($order->couple_date_of_birth == 1) ? null : $order->couple_date_of_birth;
                    $order->date_of_birth = (isset($order->date_of_birth)) ? \Carbon\Carbon::parse($order->date_of_birth) : null;
                    $order->couple_date_of_birth = (isset($order->couple_date_of_birth)) ? \Carbon\Carbon::parse($order->couple_date_of_birth) : null;
                    
                    // attempt to get Stripe charge id
                    $result=null;
                    $stripe_charge=null;
                    //   $stripe_url = trim($this->extract_value(str_replace("\r\n","\n", $message->body),"View in Stripe\n"), "<>");
                    $stripe_url = $this->extract_stripe_url($message->body);
                    if (isset($stripe_url) && strpos($stripe_url,"http") === 0) {
                        $result = Http::timeout(2)->get($stripe_url)->getBody()->getContents();
                        $charge = trim($this->extract_value($result,"redirect=%2Fpayments%2F"));
                        $stripe_charge = str_replace('">','',$charge);
                        $order->stripe_charge_id = (isset($stripe_charge)) ? $stripe_charge : null;
                    }
                    // dd($order, $message->body, $retreat, $stripe_url, $result, $stripe_charge);
                    $order->save();
                }  catch (\Exception $exception) {
                    // TODO: while debugging - could check for production or developement and turn on or off accordingly to only attempt to send email when in production
                    dd($exception, $order, $clean_message, $message->body, $retreat);

                    $subject .= ': Creating Squarespace Order for Message Id #'.$message->id;
                    Mail::send('emails.en_US.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address, 'subject' => $subject],
                    function ($m) use ($subject, $exception) {
                        $m->to(config('polanco.admin_email'))
                            ->subject('Error Retrieving Mailgun Messages');
                    });
                }
            }

            $message->is_processed=1;
            if (isset($order)) {
                $message->save();
            }
            if (isset($ss_donation)) {
                $message->save();
            }

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
    }
}
