<?php

class AcolheSUSReports
{
    private $report_fields = ["number"];

    private $excluded_fields = [
        "fld_4739909", // texto ajuda avaliacao grupos
        "fld_1123995", // anexos avaliacao grupos
        "fld_7434309", // "Markup Data" avaliacao grupos
        "fld_1473627", // "Anexar documentos" avaliacao grupos
        "fld_2690227", // "Anexar documentos" avaliacao grupos
        "fld_1093061", // "Data" avaliacao grupos
    ];

    private $caldera_forms;
    private $caldera_entries;
    private $posts;
    private $postmeta;

    public function __construct()
    {
        global $wpdb;
        $this->caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
        $this->caldera_forms = $wpdb->prefix . 'cf_forms';

        $this->posts = $wpdb->prefix . 'posts';
        $this->postmeta = $wpdb->prefix . 'postmeta';
    }

    private function getFormFields($form)
    {
        $caldera_form_id = $this->formId($form);
        $form_config = $this->getFormConfig($caldera_form_id);

        if (is_array($form_config) && array_key_exists("fields", $form_config)) {
            return $form_config["fields"];
        }

        return [];
    }

    private function formId($form_type)
    {
        $form = get_option("acolhesus");

        return $form['form_ids'][$form_type];
    }

    public function renderReports($formType, $state = null,$phase = null)
    {
        $data = $this->generateReportData($formType,$state,$phase);
        if (is_string($data) && strlen($data) > 100) {
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th> Questão </th>
                    <th> Total Geral </th>
                    <th></th>
                </tr>
                </thead>
                <tbody> <?php echo $data; ?> </tbody>
            </table>
            <?php
        } else {
            echo "<p class='text-center'> Relatório não disponível para este formulário! </p>";
        }
    }

    private function getToggleData($field_id,$label)
    {
        $sim = $this->getTotal($field_id, "Sim");
        $nao = $this->getTotal($field_id, "Não");

        $s = $this->formatSmall("(Sim)");
        $n = $this->formatSmall("(Não)");

        $row = "<td> $label </td>";
        $row .= $this->renderAnswerRow($sim . " $s/ " . $nao . " $n",'');
        $row .= $this->renderAnswerRow("", "");

        return $row;
    }

    private function getHTMLData($label)
    {
        $row = "<td> $label </td>" . $this->renderAnswerRow(""," ");
        return $row;
    }

    private function getNumericData($label,$value)
    {
        $row = $this->renderAnswerRow($label, $value);
        $row .= $this->renderAnswerRow("","");

        return $row;
    }

    private function getControlledSelectData($field_id, $label,$formType)
    {
        $respostas_fechadas = $this->getAnswerStats($field_id, true);
        if (is_array($respostas_fechadas) && count($respostas_fechadas) > 0) {
            $conta = $total = 0;
            $html = $label . "<hr>";
            foreach ($respostas_fechadas as $stats) {
                if (is_object($stats)) {
                    $total += $stats->total;
                    $_entry = $stats->value;
                    $final = $_entry;
                    $answer_post_ids = $this->setQueryForEqualAnswers($_entry);

                    $__ids = $this->getSQLResults($answer_post_ids,"total");
                    if (is_array($__ids) && count($__ids) > 0) {
                        $buffer = "&nbsp;&nbsp; <a data-toggle='collapse' href='#link-$conta' class='collapsed btn btn-default' aria-expanded='false'>Ver links</a>";
                        $buffer .= "<div id='link-$conta' class='panel-collapse collapse' aria-expanded='false'>";

                        $_found = 0;
                        $remove = true;
                        foreach($__ids as $_id) {
                            $entry = $_id->entry_id;
                            if ($this->hasAllFilters()) {
                                $subquery = $this->setSubQueryForAllFilters($formType, $entry);
                            } else if ($this->hasStateFilter() ) {
                                $subquery = $this->setSubQueryForState($formType, $entry);
                            } else if ($this->hasPhaseFilter()) {
                                $subquery = $this->setSubQueryForPhase($formType, $entry);
                            } else {
                                $subquery = $this->setDefaultSubQuery($formType,$entry);
                            }

                            $post_id = $this->getSQLResults($subquery,"row");
                            if (is_object($post_id)) {
                                $remove = false;
                                $_found++;
                                $post_id = $post_id->ID;

                                $link = get_permalink($post_id);
                                $title = get_the_title($post_id);

                                $buffer .= "<p> <a href='$link' target='_blank'>$title</a></p>";
                                $conta++;
                            }
                        }
                    }

                    if (!$remove) {
                        $final .= $buffer ."</div><hr>";
                        $html .= $_found . " - " . $final;

                    }
                }
            }
        }

        $row = $this->renderAnswerRow($html,"$conta respostas");
        $row .= $this->renderAnswerRow("","");

        return $row;
    }

    private function generateReportData($formType, $state = null, $phase = null)
    {
        $c = 0;
        $total_geral = 0;
        $table_row = "";
        foreach ($this->getFormFields($formType) as $id => $campo) {
            $tipo = $campo["type"];
            $info_data = "";

            if (in_array($tipo, $this->report_fields)) {

                if (is_string($state) && (strlen($state) === 2)) {
                    $value = $this->getFilterFor("campo",$formType, $id, $state);
                } else if (is_string($phase)) {
                    $value = $this->getFilterFor("fase",$formType, $id, $phase);
                } else {
                    $value = intval($this->getAnswerStats($id));
                }

                $info_data = $this->getNumericData($campo["label"],$value);
                if ($campo["type"] === "number") {
                    if ($c === 4) {
                        $c = -1;
                        $total_geral = 0;
                    } else {
                        $total_geral += intval($this->getAnswerStats($id));
                    }

                    $c++;
                }

            } else if ($tipo === "html" && !in_array($id, $this->excluded_fields)) {
                $info_data = $this->getHTMLData($campo["config"]["default"]);
            } else if ($tipo === "toggle_switch") {
                $info_data = $this->getToggleData($id,$campo["label"]);
            } else if ($tipo === "filtered_select2") {
                $info_data = $this->getControlledSelectData($id,$campo["label"],$formType);
            }  else {
                if ($formType === "matriz_p_criticos" && "wysiwyg" === $tipo) {
                    $r = $this->getAnswer($id);
                    $info_data = $this->renderAnswerRow($campo["label"],$r);
                }
            }

            $table_row .= "<tr>";
            $table_row .= $info_data;
            $table_row .= "</tr>";
        }

        return $table_row;
    }

    private function renderAnswerRow($total, $label) {
        $text = $this->formatSmall($label);
        return "<td> $total </td> <td> $text </td>";
    }

    private function formatSmall($text) {
        return "<span><i><small> $text </small></i></span>";
    }

    private function getFormConfig($form_id)
    {
        $sql = "SELECT config FROM " . $this->caldera_forms . " WHERE form_id='$form_id'";
        $result = $this->getSQLResults($sql, "row");

        if (is_object($result)) {
            $return = $result->config;

            if (is_string($return) && (strlen($return) > 100)) {
                return unserialize($return);
            }
        } else {
            echo $this->formNotSet();
        }
    }

    private function formNotSet()
    {
        return "<p class='text-center'> Formulário não configurado. </p>";
    }

    private function getTotal($field_id, $value)
    {
        if (is_string($field_id)) {
            $sql = "SELECT COUNT(*) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id' AND value='$value'";

            return $this->getSQLResults($sql, "row")->total;
        }
    }

    private function getAnswerStats($field_id, $closed = false)
    {

        if (is_string($field_id)) {
            if ($closed) {
                $sql = "SELECT count(*) as total, value FROM " . $this->caldera_entries . " WHERE field_id='$field_id' GROUP BY value ORDER BY total DESC";
                return $this->getSQLResults($sql, "total");
            } else {
                $sql = "SELECT SUM(value) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";

                return $this->getSQLResults($sql, "row")->total;
            }
        }

        return [];
    }

    private function getAnswer($field_id)
    {
        $sql = "SELECT value FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";
        $data = $this->getSQLResults($sql,"row");

        if (is_object($data)) {
            return $data->value;
        }

        return " --- ";
    }

    private function getFilterFor($type, $formType, $field_id, $value) {
        if ("fase" === $type) {
            $key = "acolhesus_fase";
        } else if("campo" === $type) {
            $key = "acolhesus_campo";
        }

        $sql = "SELECT ID FROM $this->posts p INNER JOIN $this->postmeta pm ON p.ID=pm.post_id AND p.post_type='$formType' AND pm.meta_key='$key' AND pm.meta_value='$value';";
        $state_ids = $this->getSQLResults($sql, "total");

        $entry_ids = [];
        if (is_array($state_ids)) {
            foreach ($state_ids as $state) {
                $_id = $state->ID;
                if (!is_null($_id)) {
                    $sql = "SELECT meta_value as total FROM $this->postmeta WHERE meta_key='_entry_id' AND post_id=$_id";
                    $formulario = $this->getSQLResults($sql, "row");

                    if (!is_null($formulario) && is_object($formulario)) {
                        $entry_ids[] = $formulario->total;
                    }
                }
            }
        }

        if (count($entry_ids) > 0) {
            $field_id = trim($field_id);

            if (count($entry_ids) == 1) {
                $el = $entry_ids[0];
                $condition = "='$el'";
            } else {
                $condition = "IN (" . implode( ',' ,$entry_ids) . ")";
            }
            $sql = "SELECT SUM(value) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id' AND entry_id $condition";

            $res = $this->getSQLResults($sql, "row")->total;

            if (is_null($res)) {
                $res = "---";
            }

            return $res;
        }
    }

    private function setSubQueryForState($formType, $entry) {
        $state = sanitize_text_field($_POST["campo"]);
        return $this->baseFilterQuery("campo",$formType, $entry, $state);
    }

    private function setSubQueryForPhase($formType, $entry) {
        $phase = sanitize_text_field($_POST["fase"]);
        return $this->baseFilterQuery("fase",$formType, $entry, $phase);
    }

    private function setSubQueryForAllFilters($formType, $entry) {
        return $this->baseFilterQuery("all",$formType, $entry,"");
    }

    private function setDefaultSubQuery($formType,$entry)
    {
        $query = "SELECT ID FROM ". $this->posts ." p WHERE p.post_type='$formType' AND ID=(SELECT pm.post_id FROM ". $this->postmeta ." pm WHERE meta_key='_entry_id' AND meta_value=$entry)";
        return $query;
    }

    private function setQueryForEqualAnswers($value) {
        return "SELECT entry_id FROM " . $this->caldera_entries . " WHERE value LIKE '$value'";
    }

    private function baseFilterQuery($tipo, $formType, $entry, $val) {
        $base_sql = "SELECT ID FROM  ". $this->posts ." p 
                          INNER JOIN ". $this->postmeta ." as mt ON mt.post_id = p.ID";
        $sufix_sql = " AND mt.meta_key='_entry_id' AND mt.meta_value=$entry;";

        if ("all" === $tipo) {
            $state = sanitize_text_field($_POST["campo"]);
            $phase = sanitize_text_field($_POST["fase"]);

            $query = " INNER JOIN ". $this->postmeta ." as mta ON mta.post_id = p.ID 
                       INNER JOIN ". $this->postmeta ." as mtc ON mtc.post_id = p.ID 
                            WHERE p.post_type='$formType'
                            AND mta.meta_key='acolhesus_fase'  AND mta.meta_value='$phase'
                            AND mtc.meta_key='acolhesus_campo' AND mtc.meta_value='$state' ";

            $sql = $base_sql . $query . $sufix_sql;
        } else {
            if ("fase" === $tipo) {
                $key = "acolhesus_fase";
            } else if ("campo" === $tipo) {
                $key = "acolhesus_campo";
            } else {
                return "";
            }

            $query = " INNER JOIN ". $this->postmeta ." as mta ON mta.post_id = p.ID 
                            WHERE p.post_type='$formType'
                            AND mta.meta_key='$key' AND mta.meta_value='$val'";

            $sql = $base_sql . $query . $sufix_sql;
        }

        return $sql;
    }

    public function hasStateFilter()
    {
       return (isset($_POST["campo"]) && (strlen($_POST["campo"]) === 2));
    }

    public function hasPhaseFilter()
    {
        return (isset($_POST["fase"]) && (strlen($_POST["fase"]) >= 6));
    }

    private function hasAllFilters()
    {
        return $this->hasPhaseFilter() && $this->hasStateFilter();
    }

    private function getSQLResults($sql, $type) {
        global $wpdb;

        if ("row" === $type) {
            return $wpdb->get_row($sql);
        } else if ("total" === $type) {
            return $wpdb->get_results($sql);
        } else {
            return [];
        }
    }

}