<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\HttpTestAssertions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, HttpTestAssertions;

    protected function stristrarray($array, $str)
    {
        //This array will hold the indexes of every
        //element that contains our substring.
        $indexes = [];
        foreach ($array as $k => $v) {
            //If stristr, add the index to our
            //$indexes array.
            if (stristr($v, $str)) {
                $indexes[] = $k;
            }
        }

        return $indexes;
    }

    protected function createUserWithPermission(string $permission, array $data = [])
    {
        $reference = \App\Models\Permission::where('name', $permission)->first();
        if (is_null($reference)) {
            throw new \InvalidArgumentException('permission does not exist: '.$reference);
        }

        $role = \App\Models\Role::where('name', 'test-role:'.$permission)->first();
        if (is_null($role)) {
            throw new \InvalidArgumentException('A test role for the permission ('.$permission.') does not exist. Did you run the seeder?');
        }

        $user = \App\Models\User::factory()->create($data);
        $user->assignRole($role->name);

        return $user;
    }

    /**
     * checks the response content to ensure that a field's default value for a particular form object is found.
     *
     * @param string $field_name
     * @param string $field_value
     * @param string $form_type
     * @param string $contents
     * @return bool
     */
    protected function findFieldValueInResponseContent(string $field_name, $field_value, string $form_type, $contents)
    {   // form_type can be number (default), text, select, date
        // initialize default variables
        $line_number = 0;
        $value_found = 0;
        // dd($field_value);
        $field_name_string = 'name="'.$field_name.'"';
        $field_value_string = 'value="'.e($field_value).'"';
        $contents_array = explode("\n", $contents);

        switch ($form_type) {
            case 'number':
                break;
            case 'date':
                // dd($field_value, gettype($field_value), $field_value->format('Y-m-d'));
                if (! is_null($field_value)) {
                    $field_value_string = 'value="'.$field_value->format('Y-m-d').'"';
                } else {
                    return true;
                }
                break;
            case 'datetime':
                if (! is_null($field_value)) {
                    $field_value_string = 'value="'.$field_value->format('Y-m-d\TH:i:sP').'"';
                } else {
                    return true;
                }
                break;
            case 'text':
                break;
            case 'select':
                $field_value_string = '<option value="'.$field_value.'" selected="selected">';
                $field_no_value_string = '<option value="" selected="selected">';
                $field_zero_value_string = '<option value="0" selected="selected">';

                break;
            case 'checkbox':
                $field_value_string = 'checked="checked"';
                break;
            case 'textarea': // textarea should be value and then the end of the textarea tag
                $field_value_string = $field_value.'</textarea>';
                break;
            case 'multiselect':
                break;
            default:
                break;
        }

        foreach ($contents_array as $content_key=>$content_value) {
            if (strpos($content_value, $field_name_string) !== false) {
                $line_number = $content_key;
            }
        }
        if ($line_number) {
            switch ($form_type) {
                // checkbox is handled differently, it adds a checked parameter rather than using the database value
                case 'checkbox':
                    if ($field_value == true) { // if the database value is true, ensure the selected param is in fact present on the line
                        $value_found = (strpos($contents_array[$line_number], 'checked="checked"'));
                    } else { // if the database value is false then, ensure that the checked param is NOT on the line
                        $value_found = ! (strpos($contents_array[$line_number], 'checked="checked"'));
                    }
                    break;
                // deal with cases where selected value is 0 or not yet defined by checking for 0
                case 'select':
                    if (is_null($field_value)) {
                        $value_found = (! (strpos($contents_array[$line_number], 'selected="selected"')) || strpos($contents_array[$line_number], $field_zero_value_string) || strpos($contents_array[$line_number], $field_no_value_string));
                    } else {
                        $value_found = (strpos($contents_array[$line_number], $field_value_string) || strpos($contents_array[$line_number], $field_zero_value_string));
                    }
                    // dd($value_found, strpos($contents_array[$line_number], $field_value_string),  )
                    break;
                case 'multiselect': //count the number of selected options on the line & count the number of selected default field values - then compare that they are the same
                    $results = [];
                    if (is_null($field_value)) {
                        $value_found = (! (strpos($contents_array[$line_number], 'selected="selected"')) || strpos($contents_array[$line_number], $field_zero_value_string));
                    } else { // build array $results of selected values
                        foreach ($field_value as $key => $value) {
                            $field_value_string = '<option value="'.$value.'" selected="selected">';
                            $field_no_value_string = '<option value="" selected="selected">';
                            $field_zero_value_string = '<option value="0" selected="selected">';

                            $value_found = boolval(strpos($contents_array[$line_number], $field_value_string) || strpos($contents_array[$line_number], $field_zero_value_string));
                            $results[$key] = $value_found;
                        }
                        $options = explode('<option ', $contents_array[$line_number]);
                        $options_count = count($this->stristrarray($options, 'selected="selected">'));
                        $results_count = count($this->stristrarray($results, '1'));

//                        dd(count($selected_options), count($field_value), $value_found, $field_name, $field_value,$line_number,$contents_array[$line_number],$results, $options);
                    }
                    // dd(count($field_value), $field_value, $options_count, $options, $results_count, $results);
                    return ($options_count == $results_count) && (count($field_value) == $results_count);
                    break;
                case 'text':
                    if (is_null($field_value)) { //if there is no value there shouldn't be a default value
                        $value_found = ! (strpos($contents_array[$line_number], 'value="'));
                    } else { // if there is a value it should be set as the default
                        $value_found = strpos($contents_array[$line_number], $field_value_string);
                    }
                    break;
                default: // by default check that the database value appears as the value param
                    $value_found = strpos($contents_array[$line_number], $field_value_string);
                    break;
            }
        }
        if ($value_found > 0) {
            return true;
        } else {
            dd($value_found, $line_number, $field_value, $field_name_string, $field_value_string, gettype($field_value_string), $contents_array[$line_number]);

            return false;
        }
    }
}
