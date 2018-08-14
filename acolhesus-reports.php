<?php

class AcolheSUSReports
{
    private $report_fields = ["number"];

    private $excluded_fields = [
        "fld_4739909", // texto ajuda avaliacao grupos
        "fld_1123995", // anexos avaliacao grupos
        "fld_7434309", // "Markup Data" avaliacao grupos
        "fld_1473627", // "Anexar documentos" avaliacao grupos
    ];

    private $caldera_entries;

    public function __construct()
    {
        global $wpdb;
        $this->caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
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

        if (is_array($f) && array_key_exists("fields", $f)) {
            return $f["fields"];
        }

        return [];
    }

    public function form_id($form_type)
    {
        $f = get_option("acolhesus");

        return $f['form_ids'][$form_type];
    }

    public function renderReports($formType, $state = null)
    {
        $data = $this->generateReportData($formType,$state);
        if (is_string($data) && strlen($data) > 100) {
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th> Questão </th>
                    <th> - </th>
                    <th> Total</th>
                </tr>
                </thead>
                <tbody> <?php echo $data; ?> </tbody>
            </table>
            <?php
        } else {
            echo "<p class='text-center'>Relatório não disponível para este formulário!</p>";
        }
    }

    private function generateReportData($formType, $state = null)
    {
        $c = 0;
        $total_geral = 0;
        $t = "";
        foreach ($this->get_form_fields($formType) as $id => $campo ) {
            $tipo = $campo["type"];
            $e = "";

            if ( in_array($tipo, $this->report_fields) ) {
                if (is_null($state)) {
                    $v = intval($this->getAnswersFor($id));
                } else if (is_string($state) && (strlen($state) === 2)) {
                    $v = $this->getStateFilter($formType, $id, $state);
                    if (is_object($v)) {
                        $v = $v->total;
                    } else {
                        $v = "";
                    }
                }

                $e = $this->renderAnswerRow($v, $campo["label"]);
                $e .= $this->renderAnswerRow(""," ");

                if ($campo["type"] === "number") {

                    if ($c === 4) {
                        $c = -1; // echo "<br>"; // $total_geral - exibir aqui?
                        $total_geral = 0;
                    } else {
                        $total_geral += intval($this->getAnswersFor($id));
                    }

                    $c++;
                }

            } else if ($tipo === "html" && !in_array($id, $this->excluded_fields)) {

                $e = "<td> " . $campo["config"]["default"] . "</td>";
                $e .= $this->renderAnswerRow(""," ");
                $e .= $this->renderAnswerRow(""," ");

            } else if ($tipo === "toggle_switch") {
                $sim = $this->getTotal($id, "Sim");
                $nao = $this->getTotal($id, "Não");
                $e = "<td> " . $campo["label"] . "</td>";

                $e .= $this->renderAnswerRow($sim," Sim");
                $e .= $this->renderAnswerRow($nao, " Não");
            } else if ($tipo === "filtered_select2") {
                $v = $this->getClosedListResults($id);

                $html = "";
                $total = 0;
                if (is_array($v)) {
                    foreach ($v as $_) {
                        $total += $_->total;
                        $html .= $_->total . " - " . $_->value . " <br> ";
                    }
                }

                $e = "<td> " . $campo["label"] . "</td>";
                $e .= $this->renderAnswerRow($html,"$total respostas");
            }

            $t .= "<tr>";
            $t .= $e;
            $t .= "</tr>";
        }

        return $t;
    }

    private function renderAnswerRow($total, $label) {
        return "<td> $total </td> <td> <span><i><small> $label </small></i></span> </td>";
    }

    private function get_form_config($form_id)
    {
        global $wpdb;
        $caldera_forms = $wpdb->prefix . 'cf_forms';
        $sql = "SELECT config FROM " . $caldera_forms . " WHERE form_id='$form_id'";

        $result = $wpdb->get_row($sql);

        if (is_object($result)) {
            $return = $result->config;

            if (is_string($return) && (strlen($return) > 100)) {
                return unserialize($return);
            }
        } else {
            echo "<p class='text-center'>Formulário não configurado.</p>";
        }

    }

    private function get_sql_results($sql, $type) {
        global $wpdb;

        if ("row" === $type) {
            return $wpdb->get_row($sql);
        } else if ("total" === $type) {
            return $wpdb->get_results($sql);
        }
    }

    private function getTotal($field_id, $value)
    {
        if (is_string($field_id)) {
            $sql = "SELECT COUNT(*) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id' AND value='$value'";

            return $this->get_sql_results($sql, "row")->total;
        }
    }

    private function getAnswersFor($field_id)
    {
        if (is_string($field_id)) {
            $sql = "SELECT SUM(value) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";

            return $this->get_sql_results($sql, "row")->total;
        }

        return [];
    }

    private function getClosedListResults($field_id)
    {
        if (is_string($field_id)) {
            global $wpdb;
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $sql = "SELECT count(*) as total, value FROM " . $caldera_entries . " WHERE field_id='$field_id' GROUP BY value ORDER BY total DESC;";

            return $this->get_sql_results($sql, "total");
        }

        return [];
    }

    public function getStateFilter($formType,$field_id,$state) {
        global $wpdb;
        $meta = $wpdb->prefix . 'postmeta';
        $p = $wpdb->prefix . 'posts';

        $sql = "SELECT ID FROM $p p INNER JOIN $meta pm ON p.ID=pm.post_id AND p.post_type='$formType' AND pm.meta_key='acolhesus_campo' AND pm.meta_value='$state';";
        $i = $wpdb->get_results($sql);

        $entry_ids = [];
        if (is_array($i)) {
            foreach ($i as $resp) {
                $a = $resp->ID;
                if (!is_null($a)) {
                    $s = "SELECT meta_value as v FROM $meta WHERE meta_key='_entry_id' AND post_id=$a";
                    $__ = $wpdb->get_row($s);

                    if (!is_null($__)) {
                        $entry_ids[] = $__->v;
                    }
                }
            }
        }

        if (count($entry_ids) > 0) {
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $field_id = trim($field_id);

            if (count($entry_ids) == 1) {
                $el = $entry_ids[0];
                $IN = "='$el'";
            } else {
                $IN = "IN (" . implode( ',' ,$entry_ids) . ")";
            }

            $sql = "SELECT SUM(value) as total FROM " . $caldera_entries . " WHERE field_id='$field_id' AND entry_id $IN";


            return $wpdb->get_row($sql);
        }
    }

}