<?php

namespace App\Traits;

trait PhoneTrait
{
    /*
     * Takes an unformatted phone number with possible extension
     * Returns array with phone_numeric, phone_extension, and phone_formatted values
     */
    public function format_phone($phone)
    {
        $phone_extension = '';
        $phone_numeric = $phone;
        $phone_numeric = str_replace(' ', '', $phone_numeric);
        $phone_numeric = str_replace('(', '', $phone_numeric);
        $phone_numeric = str_replace(')', '', $phone_numeric);
        $phone_numeric = str_replace('-', '', $phone_numeric);
        $phone_numeric = str_replace('ext.', ',', $phone_numeric);
        $phone_numeric = str_replace('x', ',', $phone_numeric);

        if (strpos($phone_numeric, ',') > 0) {
            $phone_extension = substr($phone_numeric, strpos($phone_numeric, ',') + 1);
            $phone_numeric = substr($phone_numeric, 0, strpos($phone_numeric, ','));
        }

        if (strlen($phone_numeric) == 10) { // if US number then format
            $phone_formatted = '('.substr($phone_numeric, 0, 3).') '.substr($phone_numeric, 3, 3).'-'.substr($phone_numeric, 6, 4);
        } else { //if International then store as all numbers
            $phone_formatted = $phone_numeric;
        }

        $clean_phone = [];
        $clean_phone['phone_numeric'] = $phone_numeric;
        $clean_phone['phone_extension'] = $phone_extension;
        $clean_phone['phone_formatted'] = $phone_formatted;

        return $clean_phone;
    }
}
