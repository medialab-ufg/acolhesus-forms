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

        return $f["fields"][$slug];
    }

    function get_form_fields($form)
    {
        $d = $this->form_id($form);
        $f = $this->get_form_config($d);

        return $f["fields"];
    }

    public function form_id($form_type)
    {
        $f = get_option("acolhesus");

        return $f['form_ids'][$form_type];
    }

    public function generateReports($formType)
    {
        $c = 0;
        $total_geral = 0;
        foreach ($this->get_form_fields($formType) as $id => $campo ) {
            // "filtered_select2"
            if ( in_array($campo["type"], ["number"]) ) {
                echo intval($this->getAnswersFor($id)) . " - <span><i><small>" . $campo["label"] . "</small></i></span> $id <br>";
                if ($campo["type"] === "number") {

                    if ($c === 4) {
                        echo "<br>"; // $total_geral
                        $c = -1;
                        $total_geral = 0;
                    } else {
                        $total_geral += intval($this->getAnswersFor($id));
                    }

                    $c++;
                }

            } else if ($campo["type"] === "html") {
                echo $campo["config"]["default"];
            }
        }
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