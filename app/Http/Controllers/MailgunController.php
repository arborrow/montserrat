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

        $mg = new Mailgun(config('settings.mailgun_secret'));
        $domain = config('settings.mailgun_domain');
        $queryString = ['event' => 'stored'];
        $emails = '';
        $messages = new \Illuminate\Support\Collection;

//
        $results = $mg->get("$domain/events", $queryString);
        //dd($results);
        if (array_key_exists('http_response_body', $results)) {
            //dd('found');
            foreach ($results->http_response_body as $body) {
                //dd($body);
                foreach ($body as $email) {
                    if (isset($email->event) && ($email->event == 'stored')) {
                        if (isset($email->message->headers->from)) {
                            $email->from = self::clean_email((string) $email->message->headers->from);
                        }
                        if (isset($email->message->headers->to)) {
                            $email->to = self::clean_email((string) $email->message->headers->to);
                        }
                        $messages->push($email);

                        $email->staff = \App\Contact::whereHas('groups', function ($query) {
                            $query->where('group_id', '=', config('polanco.group_id.staff'));
                        })
                            ->whereHas('emails', function ($query) use ($email) {
                                $query->whereEmail($email->from);
                            })->first();
                        $email->contact = \App\Contact::whereHas('emails', function ($query) use ($email) {
                            $query->whereEmail($email->to);
                        })->first();
                        //dd($email->id);
                        $message = \App\Message::firstOrCreate(['mailgun_id'=>$email->id]);
                        $message->from = $email->from;
                        if (isset($email->staff['id'])) {
                            $message->from_id = $email->staff['id'];
                        }
                        $message->to = $email->to;
                        if (isset($email->contact['id'])) {
                            $message->to_id = $email->contact['id'];
                        }

                        if (isset($email->message->headers->subject)) {
                            $message->subject = substr($email->message->headers->subject, 0, 255);
                        }

                        $message->mailgun_timestamp = $email->timestamp;
                        if (isset($email->storage->url)) {
                            $message->storage_url = $email->storage->url;
                        }

                        if (isset($email->headers->subject)) {
                            $message->subject = $email->headers->subject;
                        }
                        //dd($message);
                        $message->save();
                    }
                }
            }
        } else {
            //dd('No items');
        }

        return view('mailgun.index', compact('messages', 'staff', 'contact'));
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
     * Processes stored mailgun emails after get which saves them to messages in db
     *
     */
    public function process()
    {
        $this->authorize('admin-mailgun');
        $messages = \App\Message::whereIsProcessed(0)->get();

        foreach ($messages as $message) {
            $ch = curl_init($message->storage_url);
            //dd($ch);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, 'api:'.config('settings.mailgun_secret'));

            //dd($ch);
            $output = curl_exec($ch);
            //dd($output);
            curl_close($ch);
            $json = json_decode($output, true);

            $message->body = $json['body-plain'];
            $message->is_processed = 1;
            $message->save();

            // if we have from and to ids for contacts go ahead and create a touchpoint
            if (($message->from_id > 0) && ($message->to_id > 0)) {
                $touch = new \App\Touchpoint();
                $touch->person_id = $message->to_id;
                $touch->staff_id = $message->from_id;
                $touch->touched_at = $message->timestamp;
                $touch->type = 'Email';
                $touch->notes = $message->subject.' - '.$message->body;
                $touch->save();
            }
        }

        $messages = \App\Message::whereIsProcessed(1)->get();
        //dd($messages);
        return view('mailgun.processed', compact('messages'));
    }
}
