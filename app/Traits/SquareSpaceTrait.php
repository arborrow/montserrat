<?php

namespace App\Traits;

use App\Models\Registration;
use App\Models\Retreat;
use Carbon\Carbon;
use DB;

trait SquareSpaceTrait
{
    /*
    *  Returns list of upcoming and active retreats with id => retreat name
    *  If $event_id is provided, then it just returns the value for that retreat
    *  If months is provided, then subtract months from today and get all retreats after the start date
    */
    public function upcoming_retreats($event_id = null, $months = 0)
    {
        $start_date = ($months > 0) ? Carbon::today()->subMonths($months) : Carbon::today();

        $retreats = Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where('end_date', '>', $start_date)->where('is_active', '=', 1)->orderBy('start_date')->pluck('description', 'id');

        if (isset($event_id)) {
            $event = Retreat::findOrFail($event_id);
            $retreats[$event->id] = $event->idnumber.'-'.$event->title.' ('.date_format($event->start_date, 'm-d-Y').')';
        }
        $retreats[''] = 'N/A';

        return $retreats;
    }

    /*
    *  Returns list of retreats for a particular retreatant/contact
    *  If $event_id is provided, then it just returns the value for that retreat
    *  If months is provided, then subtract months from today and get all retreats after the start date
    */
    public function contact_retreats($contact_id = null)
    {
        if ($contact_id > 0) {
            $retreats = Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->whereContactId($contact_id)->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');
            $retreats[''] = 'Not related to an Event/Retreat';

            return $retreats;
        }
    }

    /*
        Takes an item (either a SquarespaceOrder or SquarespaceDonation
        Requires name, email, full_address
        Gets list of contacts with same last name
        Gets list of contacts with same email
        Gets list of contacts with same phone (mobile, work, home)
        Person and returns a list of ids that may match
        Merges the contacts into a single list
        Calculates the match score based on name, email, phone, addrees
        //TODO: factor in date of birth to increase indentity confidence score
        Returns a list of contact_id => full_name_with_city (match score)
        Sorted with highest match scores first
        Creates an option for no match (create new)
    */
    public function matched_contacts($item)
    {
        $lastname = trim(substr($item->name, strrpos($item->name, ' ')));
        $firstname = trim(substr($item->name, 0, strpos($item->name, ' ')));

        $contacts = [];
        $contacts[0] = ['contact_id' => 0, 'lastname' => $lastname, 'firstname' => $firstname, 'full_name' => $item->name.' (Add New Person)', 'name_score' => 0, 'email_score' => 0, 'phone_score' => 0, 'address_score' => 0, 'total_score' => 0];

        $lastnames = \App\Models\Contact::whereLastName($lastname)->with('address_primary')->get();
        $emails = (isset($item->email)) ? \App\Models\Email::whereEmail(strtolower($item->email))->select('id', 'contact_id', 'email')->with('owner')->get() : [];
        $mobile_phones = (! empty($item->mobile_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->mobile_phone))->with('owner')->get() : [];
        $home_phones = (! empty($item->home_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->home_phone))->with('owner')->get() : [];
        $work_phones = (! empty($item->work_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->work_phone))->with('owner')->get() : [];
        // TODO: consider using full address
        foreach ($lastnames as $ln) {
            $name_parts = explode(' ', $item->name);
            $address_parts = explode(' ', str_replace(',', '', $item->full_address));
            $name_score = 0;
            $address_score = 0;
            $dob_score = 0;
            $name_found = 0;
            $address_found = 0;
            $name_size = (count($name_parts) > 0) ? count($name_parts) : 1; //avoid division by 0
            $address_size = (count($address_parts) > 0) ? count($address_parts) : 1; //avoid division by 0

            foreach ($name_parts as $name_part) {
                $name_found = (strpos(strtolower($ln->full_name_with_city), strtolower($name_part)) === false) ? $name_found : $name_found + 1;
            }
            $name_score = ($name_found / $name_size) * 30;

            foreach ($address_parts as $address_part) {
                $contact_full_address = $ln->address_primary_street.' '.$ln->address_primary_supplemental_address.' '.$ln->address_primary_city.' '.$ln->address_primary_state.' '.$ln->address_primary_postal_code;
                $address_found = (strpos(strtolower($contact_full_address), strtolower($address_part)) === false) ? $address_found : $address_found + 1;
            }
            // dd($address_parts,$ln->address_primary_street,$address_found,);
            $address_score = intval(($address_found / $address_size) * 10);
            // dd($item->full_address, $contact_full_address, $address_parts, $address_found, $address_size, $address_score);
            if (isset($item->date_of_birth)) {
                $item->date_of_birth = \Carbon\Carbon::parse($item->date_of_birth);
                $dob_score = ($ln->birth_date == $item->date_of_birth) ? 10 : 0;
            }
            // dd($item->date_of_birth, $ln->birth_date, $dob_score);
            $contacts[$ln->id]['contact_id'] = $ln->id;
            $contacts[$ln->id]['name_score'] = $name_score;
            $contacts[$ln->id]['address_score'] = $address_score;
            $contacts[$ln->id]['lastname'] = $ln->last_name;
            $contacts[$ln->id]['firstname'] = $ln->first_name;
            $contacts[$ln->id]['total_score'] = $name_score + $address_score + $dob_score;
            $contacts[$ln->id]['full_name'] = $ln->full_name_with_city.' ['.$contacts[$ln->id]['total_score'].']';
            // dd($name_score, $address_score, $dob_score, $contacts);
        }

        foreach ($emails as $email) {
            $email_score = 20;
            if (isset($email->owner)) { //ignore cases where the parent contact may have been deleted and thus the owner is null
                $contacts[$email->contact_id]['contact_id'] = $email->contact_id;
                $contacts[$email->contact_id]['lastname'] = $email->owner->last_name;
                $contacts[$email->contact_id]['firstname'] = $email->owner->first_name;
                $contacts[$email->contact_id]['email_score'] = $email_score;
                if (isset($contacts[$email->contact_id]['total_score'])) {
                    $contacts[$email->contact_id]['total_score'] += $email_score;
                } else {
                    $contacts[$email->contact_id]['total_score'] = $email_score;
                }
                $contacts[$email->contact_id]['full_name'] = $email->owner->full_name_with_city.' ['.(int) $contacts[$email->contact_id]['total_score'].']';
            }
        }

        foreach ($mobile_phones as $phone) {
            $phone_score = 20;
            if (isset($phone->owner)) {
                $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
                $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
                $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
                $contacts[$phone->contact_id]['mobile_phone_score'] = $phone_score;
                if (isset($contacts[$phone->contact_id]['total_score'])) {
                    $contacts[$phone->contact_id]['total_score'] += $phone_score;
                } else {
                    $contacts[$phone->contact_id]['total_score'] = $phone_score;
                }
                $contacts[$phone->contact_id]['full_name'] = $phone->owner->full_name_with_city.' ['.(int) $contacts[$phone->contact_id]['total_score'].']';
            }
        }

        foreach ($home_phones as $phone) {
            $phone_score = 10;
            if (isset($phone->owner)) {
                $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
                $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
                $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
                $contacts[$phone->contact_id]['home_phone_score'] = $phone_score;
                if (isset($contacts[$phone->contact_id]['total_score'])) {
                    $contacts[$phone->contact_id]['total_score'] += $phone_score;
                } else {
                    $contacts[$phone->contact_id]['total_score'] = $phone_score;
                }
                $contacts[$phone->contact_id]['full_name'] = $phone->owner->full_name_with_city.' ['.(int) $contacts[$phone->contact_id]['total_score'].']';
            }
        }

        foreach ($work_phones as $phone) {
            $phone_score = 10;
            if (isset($phone->owner)) {
                $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
                $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
                $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
                $contacts[$phone->contact_id]['work_phone_score'] = $phone_score;
                if (isset($contacts[$phone->contact_id]['total_score'])) {
                    $contacts[$phone->contact_id]['total_score'] += $phone_score;
                } else {
                    $contacts[$phone->contact_id]['total_score'] = $phone_score;
                }
                $contacts[$phone->contact_id]['full_name'] = $phone->owner->full_name_with_city.' ['.(int) $contacts[$phone->contact_id]['total_score'].']';
            }
        }

        $ts = array_column($contacts, 'total_score');
        array_multisort($ts, SORT_DESC, $contacts);
        $list = array_column($contacts, 'full_name', 'contact_id');

        return $list;
    }
}
