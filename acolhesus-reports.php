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

    function get_form_fields($form)
    {
        $caldera_form_id = $this->form_id($form);
        $f = $this->get_form_config($caldera_form_id);

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
                    <th> Total </th>
                    <th> Detalhes </th>
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
                    $v = intval($this->getAnswerStats($id));
                } else if (is_string($state) && (strlen($state) === 2)) {
                    $v = $this->getStateFilter($formType, $id, $state);
                    if (is_string($v)) {
                        $v = intval($v);
                    } else {
                        $v = "---";
                    }
                }

                $e = $this->renderAnswerRow($v, $campo["label"]);
                $e .= $this->renderAnswerRow(""," ");

                if ($campo["type"] === "number") {
                    if ($c === 4) {
                        $c = -1; // echo "<br>"; // $total_geral - exibir aqui?
                        $total_geral = 0;
                    } else {
                        $total_geral += intval($this->getAnswerStats($id));
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
                $respostas_fechadas = $this->getAnswerStats($id, true);

                $html = "";
                $total = 0;
                if (is_array($respostas_fechadas) && count($respostas_fechadas) > 0) {
                    $conta = 0;
                    foreach ($respostas_fechadas as $stats) {
                        if (is_object($stats)) {
                            $total += $stats->total;
                            $_entry = $stats->value;
                            $final = $_entry;
                            $answer_post_ids = "SELECT entry_id FROM " . $this->caldera_entries . " WHERE value LIKE '$_entry'";

                            $__ids = $this->get_sql_results($answer_post_ids,"total");

                            if (is_array($__ids) && count($__ids) > 0) {
                                $buffer = "&nbsp;&nbsp; <a data-toggle='collapse' href='#link-$conta' class='collapsed btn btn-default' aria-expanded='false'>Ver links</a>";
                                $buffer .= "<div id='link-$conta' class='panel-collapse collapse' aria-expanded='false'>";

                                $encontrados = 0;
                                $remove = true;
                                foreach($__ids as $_id) {
                                    $d = $_id->entry_id;

                                    /*
                                     * TODO: Quebrar esses selects em outras funções
                                     * */
                                    if (isset($_POST["campo"])) {
                                        $_campo = sanitize_text_field($_POST["campo"]);
                                        $subquery = "SELECT ID 
                                                    FROM ". $this->posts ." p 
                                                        INNER JOIN ". $this->postmeta ." as mt ON mt.post_id = p.ID 
                                                        INNER JOIN ". $this->postmeta ." as mta ON mta.post_id = p.ID 
                                                    WHERE p.post_type='$formType'
                                                    AND mt.meta_key='acolhesus_campo' AND mt.meta_value='$_campo'
                                                    AND mta.meta_key='_entry_id' AND mta.meta_value=$d
                                                ";
                                    } else {
                                        $subquery = "SELECT ID FROM ". $this->posts ." p WHERE p.post_type='$formType' AND ID=(SELECT pm.post_id FROM ". $this->postmeta ." pm WHERE meta_key='_entry_id' AND meta_value=$d)";
                                    }

                                    $post_id = $this->get_sql_results($subquery,"row");
                                    if (is_object($post_id)) {
                                        $remove = false;
                                        $encontrados++;
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
                                $html .= $encontrados . " - " . $final;

                            }
                        }
                    }
                }

                $e = $this->renderAnswerRow($html,"$conta respostas");
                $e .= "<td>" . $campo["label"] . "</td>";
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
        $sql = "SELECT config FROM " . $this->caldera_forms . " WHERE form_id='$form_id'";
        $result = $this->get_sql_results($sql, "row");

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

            return $this->get_sql_results($sql, "row")->total;
        }
    }

    private function getAnswerStats($field_id, $closed = false)
    {

        if (is_string($field_id)) {
            if ($closed) {
                $sql = "SELECT count(*) as total, value FROM " . $this->caldera_entries . " WHERE field_id='$field_id' GROUP BY value ORDER BY total DESC";
                return $this->get_sql_results($sql, "total");
            } else {
                $sql = "SELECT SUM(value) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";

                return $this->get_sql_results($sql, "row")->total;
            }
        }

        return [];
    }

    public function getStateFilter($formType,$field_id,$state) {

        $sql = "SELECT ID FROM $this->posts p INNER JOIN $this->postmeta pm ON p.ID=pm.post_id AND p.post_type='$formType' AND pm.meta_key='acolhesus_campo' AND pm.meta_value='$state';";
        $state_ids = $this->get_sql_results($sql, "total");

        $entry_ids = [];
        if (is_array($state_ids)) {
            foreach ($state_ids as $state) {
                $_id = $state->ID;
                if (!is_null($_id)) {
                    $sql = "SELECT meta_value as total FROM $this->postmeta WHERE meta_key='_entry_id' AND post_id=$_id";
                    $formulario = $this->get_sql_results($sql, "row");

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

            return $this->get_sql_results($sql, "row")->total;
        }
    }

    private function get_sql_results($sql, $type) {
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