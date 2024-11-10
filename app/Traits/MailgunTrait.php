<?php

namespace App\Traits;

trait MailgunTrait
{
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
        $start_position = strpos($body, $start_text);
        $start_length = strlen($start_text);
        $end_position = strpos($body, $end_text, $start_position);

        if (($end_position > $start_position) && ! $start_position === false) {
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
        $start_position = strpos($body, $start_text);
        $start_length = strlen($start_text);

        if ($start_position >= 0) {
            $end_position = strpos($body, "\n", $start_position + $start_length);
        }
        if (($end_position > $start_position) && ! $start_position === false) {
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

    public function extract_data($body, $start_text = null, $offset = 0)
    {
        $field_position = array_search($start_text, $body) + $offset;
        if ((! $field_position === false) && array_key_exists($field_position + 1, $body)) {
            $data = $body[$field_position + 1];
        }

        // dd($body, $start_text, $field_position, $data);
        return (isset($data)) ? trim($data) : null;
    }

    /*
     * extract stripe_url
     *
     * returns
     */

    public function extract_stripe_url($message_body)
    {
        $clean_body = trim(str_replace("\r\n", "\n", $message_body));
        $body_array = array_filter(explode("\n", $clean_body));
        $body_array = array_map('trim', $body_array);
        $body_array = array_filter($body_array);
        $result = array_filter($body_array, function ($value) {
            return strpos($value, 'View in Stripe') !== false;
        });
        $result = array_values($result);
        $url = explode('"', $result[0]);

        return (array_key_exists(1, $url)) ? $url[1] : null;
    }
}
