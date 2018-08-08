<?php

class AcolheSUSReports
{
    function getAnswersFor($field_id) {
        if (is_string($field_id)) {
            global $wpdb;
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $sql = "SELECT * FROM " . $caldera_entries . " WHERE field_id='$field_id'";

            return $wpdb->get_results($sql);
        }

        return [];
    }

    public function __construct()
    {
        // nothing for now
    }
}