<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\HttpTestAssertions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, HttpTestAssertions;

    protected function createUserWithPermission(string $permission, array $data = [])
    {
        $reference = \App\Permission::where('name', $permission)->first();
        if (is_null($reference)) {
            throw new \InvalidArgumentException('permission does not exist: '.$reference);
        }

        $role = \App\Role::where('name', 'test-role:'.$permission)->first();
        if (is_null($role)) {
            throw new \InvalidArgumentException('A test role for the permission ('.$permission.') does not exist. Did you run the seeder?');
        }

        $user = factory(\App\User::class)->create($data);
        $user->assignRole($role->name);

        return $user;
    }

    /**
    * checks the response content to ensure that a field's default value for a particular form object is found
    *
    * @param string $field_name
    * @param string $field_value
    * @param string $form_type
    * @param string $contents
    * @return boolean
    */

    protected function findFieldValueInResponseContent(string $field_name, string $field_value, string $form_type = 'number', $contents)
    {   // form_type can be number (default), text, select, date
        // initialize default variables
        $line_number = 0;
        $value_found = 0;
        $field_name_string = "name=\"".$field_name."\"";
        $field_value_string = "value=\"".e($field_value)."\"";
        $contents_array = explode("\n", $contents);

        switch ($form_type) {
            case 'number':
                break;
            case 'date':
                break;
            case 'text':
                break;
            case 'select':
                $field_value_string = "<option value=\"".$field_value."\" selected=\"selected\">";
                break;
            case 'checkbox':
                $field_value_string = "checked=\"checked\"";
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
            $value_found = strpos($contents_array[$line_number], $field_value_string);
            if ($form_type == 'checkbox' && ($field_value==true)) {
                $value_found = (strpos($contents_array[$line_number], "checked=\"checked\""));
            }
            if ($form_type == 'checkbox' && ($field_value==false)) {
                // if the checkbox is not checked then the value in the database was 0 so this is a success
                $value_not_found = (strpos($contents_array[$line_number], "checked=\"checked\""));
                if ($value_not_found == 0) {
                    $value_found = 1;
                }
            }

        }
        if ($value_found > 0) {
            return true;
        } else {
            // dd($value_found, $field_name_string,$field_value_string,$contents_array);
            return false;
        }
    }
}
