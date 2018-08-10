<?php

class AcolheSUSReports
{
    private $report_fields = ["number"];

    private $excluded_fields = [
        "fld_4739909", // texto ajuda avaliacao grupos
        "fld_1123995" // anexos avaliacao grupos
    ];

    public function __construct()
    {
        // nothing for now
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

    public function renderReports($formType)
    {
        $data = $this->generateReportData($formType);
        if (is_string($data) && strlen($data) > 100) {
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th> Questão </th>
                    <th> Resposta </th>
                    <th> Total</th>
                </tr>
                </thead>
                <tbody> <?php echo $data; ?> </tbody>
            </table>
            <?php
        } else {
            echo "<center>Relatório não disponível para este formulário!</center>";
        }
    }

    private function generateReportData($formType)
    {
        $c = 0;
        $total_geral = 0;
        $t = "";
        foreach ($this->get_form_fields($formType) as $id => $campo ) {

            $tipo = $campo["type"];
            $e = "";

            if ( in_array($tipo, $this->report_fields) ) {
                // echo intval($this->getAnswersFor($id)) . " - <span><i><small>" . $campo["label"] . "</small></i></span> <br>";

                $e .= $this->renderAnswerRow(""," ");
                $e = $this->renderAnswerRow(intval($this->getAnswersFor($id)), $campo["label"]);
                $e .= $this->renderAnswerRow(""," ");

                if ($campo["type"] === "number") {

                    if ($c === 4) {
                        // echo "<br>"; // $total_geral - exibir aqui?
                        $c = -1;
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
            echo "Formulário não configurado.";
        }

    }

    private function getTotal($field_id, $value)
    {
        if (is_string($field_id)) {
            global $wpdb;
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $sql = "SELECT COUNT(*) as total FROM " . $caldera_entries . " WHERE field_id='$field_id' AND value='$value'";

            return $wpdb->get_row($sql)->total;
        }
    }

    private function getAnswersFor($field_id)
    {
        if (is_string($field_id)) {
            global $wpdb;
            $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
            $sql = "SELECT SUM(value) as total FROM " . $caldera_entries . " WHERE field_id='$field_id'";

            return $wpdb->get_row($sql)->total;
        }

        return [];
    }


}