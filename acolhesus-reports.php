<?php

class AcolheSUSReports
{
    public function __construct()
    {
        // nothing for now
    }

    function getAnswersFor($field_id)
    {
        if (is_string($field_id)) {
            global $wpdb;
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $sql = "SELECT SUM(value) as total FROM " . $caldera_entries . " WHERE field_id='$field_id'";

            return $wpdb->get_row($sql)->total;
        }

        return [];
    }

    function get_field_data($slug)
    {
        $f_id = "CF5b1acc437ffd1";

        $f = $this->get_form_config($f_id);

        return Caldera_Forms::get_field_data($slug, $f);
    }


    private function get_form_config($form_id)
    {
        global $wpdb;
        $caldera_forms = $wpdb->prefix . 'cf_forms';
        $sql = "SELECT config FROM " . $caldera_forms . " WHERE form_id='$form_id'";

        $return = $wpdb->get_row($sql)->config;

        if (is_string($return) && (strlen($return) > 100)) {
            return unserialize($return);
        }
    }


}