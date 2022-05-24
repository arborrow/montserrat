<?php

namespace App\Traits;
use DB;

trait SquareSpaceTrait
{   /*
    *  Returns list of upcoming and active retreats with id => retreat name
    */
    public function upcoming_retreats() {
        $retreats = \App\Models\Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where('end_date', '>', \Carbon\Carbon::today()->subWeek())->where('is_active', '=', 1)->orderBy('start_date')->pluck('description', 'id');
        return $retreats;
        dd($retreats);
    }

    /*
        Takes an item (either a SsOrder or SsDonation
        Gets list of contacts with same last name
        Gets list of contacts with same email
        Gets list of contacts with same phone (mobile, work, home)
        Person and returns a list of ids that may match
        Merges the contacts into a single list
        Calculates the match score
        Returns a list of contact_id => full_name_with_city (match score)
        Sorted with highest match scores first
        Creates an option for no match (create new)
    */
    public function matched_contacts($item) {
        $lastname = trim(substr($item->name, strrpos($item->name,' ')));
        $firstname = trim(substr($item->name, 0, strpos($item->name,' ')));

        $contacts = [];
        $contacts[0] = ['contact_id'=>0, 'lastname'=>$lastname, 'firstname'=>$firstname, 'full_name'=>$item->name . ' (Add New Person)', 'name_score'=>0,'email_score'=>0,'phone_score'=>0,'address_score'=>0,'total_score'=>0];

        $lastnames = \App\Models\Contact::whereLastName($lastname)->get();
        $emails = (isset($item->email)) ? \App\Models\Email::whereEmail(strtolower($item->email))->select('id', 'contact_id','email')->with('owner')->get() : [];
        $mobile_phones = (isset($item->mobile_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->mobile_phone))->with('owner')->get() : [];
        $home_phones = (isset($item->home_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->home_phone))->with('owner')->get() : [];
        $work_phones = (isset($item->work_phone)) ? \App\Models\Phone::wherePhoneNumeric(preg_replace('~\D~', '', $item->work_phone))->with('owner')->get() : [];

        foreach ($lastnames as $ln) {
            $name_parts = explode(" ",$item->name);
            $address_parts = explode(" ",$item->address_street);
            $name_score = 0;
            $address_score = 0;
            $name_found = 0;
            $address_found = 0;
            $name_size = (sizeof($name_parts) > 0) ? sizeof($name_parts) : 1; //avoid division by 0
            $address_size = (sizeof($address_parts) > 0) ? sizeof($address_parts) : 1; //avoid division by 0

            foreach ($name_parts as $name_part) {
                $name_found = (strpos(strtolower($ln->full_name_with_city), strtolower($name_part)) === false) ? $name_found : $name_found+1;
            }
            $name_score = ($name_found / $name_size) * 30;

            foreach ($address_parts as $address_part) {
                $address_found = (strpos(strtolower($ln->address_primary_street), strtolower($address_part)) === false) ? $address_found : $address_found+1;
            }
            // dd($address_parts,$ln->address_primary_street,$address_found,);
            $address_score = ($address_found / $address_size) * 10;


            $contacts[$ln->id]['contact_id'] = $ln->id;
            $contacts[$ln->id]['name_score'] = $name_score;
            $contacts[$ln->id]['address_score'] = $address_score;
            $contacts[$ln->id]['total_score'] = $name_score + $address_score;
            $contacts[$ln->id]['lastname'] = $ln->last_name;
            $contacts[$ln->id]['firstname'] = $ln->first_name;
            $contacts[$ln->id]['full_name'] = $ln->full_name_with_city . ' ['. (int) $name_score + $address_score .']';

        }

        foreach ($emails as $email) {
            $email_score = 20;
            $contacts[$email->contact_id]['contact_id'] = $email->contact_id;
            $contacts[$email->contact_id]['total_score'] += $email_score;
            $contacts[$email->contact_id]['lastname'] = $email->owner->last_name;
            $contacts[$email->contact_id]['firstname'] = $email->owner->first_name;
            $contacts[$email->contact_id]['full_name'] = $email->owner->full_name_with_city . ' ['. (int) $contacts[$email->contact_id]['total_score'] .']';
            $contacts[$email->contact_id]['email_score'] = $email_score;
        }

        foreach ($mobile_phones as $phone) {
            $phone_score = 20;
            $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
            $contacts[$phone->contact_id]['total_score'] += $phone_score;
            $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
            $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
            $contacts[$email->contact_id]['full_name'] = $phone->owner->full_name_with_city . ' ['. (int) $contacts[$phone->contact_id]['total_score'] .']';
            $contacts[$phone->contact_id]['phone_score'] = $phone_score;
        }

        foreach ($home_phones as $phone) {
            $phone_score = 10;
            $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
            $contacts[$phone->contact_id]['total_score'] += $phone_score;
            $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
            $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
            $contacts[$email->contact_id]['full_name'] = $phone->owner->full_name_with_city . ' ['. (int) $contacts[$phone->contact_id]['total_score'] .']';
            $contacts[$phone->contact_id]['phone_score'] = $phone_score;
        }

        foreach ($work_phones as $phone) {
            $phone_score = 10;
            $contacts[$phone->contact_id]['contact_id'] = $phone->contact_id;
            $contacts[$phone->contact_id]['total_score'] += $phone_score;
            $contacts[$phone->contact_id]['lastname'] = $phone->owner->last_name;
            $contacts[$phone->contact_id]['firstname'] = $phone->owner->first_name;
            $contacts[$email->contact_id]['full_name'] = $phone->owner->full_name_with_city . ' ['. (int) $contacts[$phone->contact_id]['total_score'] .']';
            $contacts[$phone->contact_id]['phone_score'] += $phone_score;
        }

        $ts = array_column($contacts, 'total_score');

        array_multisort($ts, SORT_DESC, $contacts);
        $list = array_column($contacts, 'full_name','contact_id');

        return $list;
    }
}
