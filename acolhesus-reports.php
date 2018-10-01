<?php
require_once "acolhesus-common.php";

class AcolheSUSReports
{
    use AcolheSUSCommon;

    public $report_fields = ["number"];

    public $excluded_fields = [
        "fld_4739909", // texto ajuda avaliacao grupos
        "fld_1123995", // anexos avaliacao grupos
        "fld_7434309", // "Markup Data" avaliacao grupos
        "fld_1473627", // "Anexar documentos" avaliacao grupos
        "fld_2690227", // "Anexar documentos" avaliacao grupos
        "fld_1093061", // "Data" avaliacao grupos
        "fld_6620960", // "Anexos" matriz de cenários
    ];

    private $base_percent_field = [
        "fld_1123995"//Número de participantes da oficina
    ];

    private $filters = [
        "state" => "campo",
        "phase" => "fase"
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

    public function hasStateFilter()
    {
        $state = $this->filters["state"];
        return (isset($_POST[$state]) && (strlen($_POST[$state]) === 2));
    }

    public function hasPhaseFilter()
    {
        $phase = $this->filters["phase"];
        return (isset($_POST[$phase]) && (strlen($_POST[$phase]) >= 6));
    }

    public function getState()
    {
        if ($this->hasStateFilter()) {
            $state = $this->getCampo();
            return esc_attr(sanitize_text_field($_POST[$state]));
        }
    }

    public function getPhase()
    {
        if ($this->hasPhaseFilter()) {
            $phase = $this->getFase();
            return esc_attr(sanitize_text_field($_POST[$phase]));
        }
    }

    public function renderReports($formType,$desc)
    {
        $data = $this->generateReportData($formType);
        if (is_string($data) && strlen($data) > 100) {
            ?>
            <input type="hidden" id="form_type" value="<?php echo $formType; ?>">
            <table class="table table-striped">
                <thead class="reports-header">
                <tr>
                    <th> Questão </th>
                    <th> Total Geral </th>
                    <th> </th>
                    <th> </th>
                </tr>
                </thead>
                <tbody> <?php echo $data; ?> </tbody>
            </table>
            <?php
            echo $this->getReportFooter($desc);
        } else {
            echo "<p class='text-center'> Relatório não disponível para este formulário! </p>";
        }
    }

    public function renderMatrizCriticosReport($formType, $label)
    {
        $data = $this->generateMatrizCriticosReportData($formType);
        if (is_string($data) && strlen($data) > 100) {
            ?>
            <input type="hidden" id="form_type" value="<?php echo $formType; ?>">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="reports-header">
                    <tr>
                        <th> Estado </th>
                        <th> Ponto Critíco </th>
                        <th> Detalhes </th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody> <?php echo $data; ?> </tbody>
                </table>
            </div>
            <?php
            echo $this->getReportFooter($label);
        } else {
            echo "<p class='text-center'> Relatório não disponível para este formulário! </p>";
        }
    }

    private function getReportFooter($desc)
    {
        $title = $this->get_title();
        $_desc = "Relatórios de $desc";

        $left = "<div class='col-md-4 text-left'> $title </div>";
        $date = date("d/m/Y G:i");
        $right = "<div class='col-md-8 text-right'> $_desc em $date</div>";

        return "<div class='col-md-12 report-footer'> $left $right </div>";
    }

    private function getCampo()
    {
        return $this->filters["state"];
    }

    private function getFase()
    {
        return $this->filters["phase"];
    }

    public function getFormFields($form)
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

    private function getToggleData($field_id,$label,$type)
    {
        if ($this->hasStateFilter()) {
            $resposta = $this->getTotal($field_id, $type);
        } else {
            $sim = $this->getTotal($field_id, $type,"Sim");
            $nao = $this->getTotal($field_id, $type,"Não");
            $s = $this->formatSmall("(Sim)");
            $n = $this->formatSmall("(Não)");

            $resposta = $sim . " $s/ " . $nao . " $n";
        }

        $row = "<td class='matriz-cenario-question'> $label </td>";
        $row .= $this->renderAnswerRow($resposta,'');

        return $row;
    }

    private function getHTMLData($label)
    {
        $row = "<td> $label </td>" . $this->renderAnswerRow(""," ");
        return $row;
    }

    private function getNumericData($label,$value, $extra = null)
    {
        if($extra !== null)
        {
            $row = $this->renderAnswerRow($label, $value." ".$extra);
        }else {
            $row = $this->renderAnswerRow($label, intval($value));
        }

        $row .= $this->renderAnswerRow("","");

        return $row;
    }

    private function getSubTableData($dados, &$_found,&$conta,&$remove,$formType)
    {
        $_data = "";
        foreach ($dados as $_id) {
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
                $data = get_the_date('d/m/Y - G:i:s',$post_id);
                $uf = get_post_meta($post_id, "acolhesus_campo",true);
                $estado = $this->campos_completos[$uf];
                $f = get_post_meta($post_id, "acolhesus_fase",true);

                if (!empty($f)) {
                    $fase = $this->fases[$f];
                } else {
                    $fase =  '';
                }

                $a_element = "<a href='$link' target='_blank'>$title</a>";
                $_data .= "<tr> <td>$a_element </td> <td> <small> $estado <hr> $fase </small></td> <td>$data</td> </tr>";
                $conta++;
            }
        }

        return $_data;
    }

    private function subTable($data)
    {
        return "<table class='table table-condensed table-hover table-bordered subtable'>
            <thead>
                <tr>
                    <th> Resposta </th>
                    <th> Dados </th>
                    <th> Data Criação </th>                    
                </tr>
            </thead>
            <tbody> $data </tbody>
         </table>
        ";
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
                    $final = '';
                    $answer_post_ids = $this->setQueryForEqualAnswers($_entry);

                    $__ids = $this->getSQLResults($answer_post_ids,"total");
                    if (is_array($__ids) && count($__ids) > 0) {
                        $buffer = "<a data-toggle='collapse' href='#link-$conta' class='collapsed' aria-expanded='false'>$_entry</a>";
                        $buffer .= "<div id='link-$conta' class='panel-collapse collapse' aria-expanded='false'>";

                        $_found = 0;
                        $remove = true;

                        $sub_table = $this->getSubTableData($__ids,$_found,$conta,$remove,$formType);
                        $buffer .= $this->subTable($sub_table);
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

    public function getVisualEditorData($field_id, $label,$formType)
    {
        if ($formType === "matriz_p_criticos") {
            $r = $this->getAnswer($field_id,$formType);
            if (is_array($r)) {
                $result = "";
                foreach($r as $answer) {
                    $sql = "SELECT post_id FROM $this->postmeta WHERE meta_key='_entry_id' AND meta_value=$answer->entry_id";
                    $id = $this->getSQLResults($sql,"row");
                    $state = get_post_meta($id->post_id, "acolhesus_campo",true);
                    $result .= "<h4>$state</h4>" . $answer->value . "<hr>";
                }
            } else {
                $result = $r;
            }   
            
            $row = $this->renderAnswerRow($label, $result);

            return $row;
        }
    }

    private function generateMatrizCriticosReportData($formType)
    {
        global $wpdb;
        $sql = "SELECT post_title, ID FROM $wpdb->posts WHERE post_type = 'matriz_p_criticos' order by post_title";
        $ids = $wpdb->get_results($sql, ARRAY_A);
        $acolheSUS = new AcolheSUS();
        ob_start();
        foreach ($ids as $post)
        {

            $state = '';
            $id = $post['ID'];
            $post_title = $post['post_title'];
            preg_match('#\((.*?)\)#', $post_title, $state);
            $state =  $state[1];

            ?>
            <tr>
                <td rowspan="3"><?php echo $state; ?></td>
            <?php
            $info = $acolheSUS->get_specific_form_data($formType, $id);
            $print_tr = false;
            foreach ($info as $ponto_critico_name => $ponto_critico_info)
            {
                if($print_tr)
                {
                    ?>
                    <tr>
                    <?php
                }

                ?>
                <td><?php echo $ponto_critico_name; ?></td>
                <td> <?php echo $acolheSUS->wrap_specific_in_html($ponto_critico_name, $ponto_critico_info); ?></td>
                </tr>
                <?php

                $print_tr = true;
            }
        }

        return ob_get_clean();
    }

    private function generateReportData($formType)
    {
        $state = $phase = null;
        if ($this->hasStateFilter()) {
            $state = $this->getState();
        }

        if ($this->hasPhaseFilter()) {
            $phase = $this->getPhase();
        }

        $c = 0;
        $total_geral = 0;
        $table_row = "";
        $base_percent = 0;
        $percent = '';
        $fields = $this->getFormFields($formType);

        if($formType === 'avaliacao_oficina') {
            $sum = [0, 0, 0, 0, 0];
            $i = $j = 0;
            foreach($fields as $id => $campo)
            {
                $tipo = $campo["type"];
                if (in_array($tipo, $this->report_fields)) {
                    $sum[$i] += intval($this->getAnswerStats($id));
                    $j++;
                }

                if($j === 5)
                {
                    $i++;
                    $j = 0;
                }
            }
        }
        $i = $j = 0;
        foreach ($fields as $id => $campo) {
            $tipo = $campo["type"];
            $info_data = "";

            if (in_array($tipo, $this->report_fields)) {

                if (is_string($state) && (strlen($state) === 2)) {
                    $value = $this->getFilterFor($this->getCampo(),$formType, $id, $state);
                } else if (is_string($phase)) {
                    $value = $this->getFilterFor($this->getFase(),$formType, $id, $phase);
                } else {
                    $value = intval($this->getAnswerStats($id));
                    if($formType === 'avaliacao_grupos')
                    {
                        if(in_array($id, $this->base_percent_field))
                        {
                            $base_percent = $value;
                        }else
                        {
                            $percent = "(".$this->get_percent($base_percent, $value)." %)";
                        }
                    }else if($formType === 'avaliacao_oficina') {
                        $percent = "(".$this->get_percent($sum[$i], $value)." %)";
                        $j++;
                    }
                }

                $info_data = $this->getNumericData($campo["label"],$value, $percent);

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
                if($j === 5)
                {
                    $i++;
                    $j = 0;
                }
            } else if ($tipo === "toggle_switch") {
                $info_data = $this->getToggleData($id,$campo["label"],$formType);
            } else if ($tipo === "filtered_select2") {
                $info_data = $this->getControlledSelectData($id,$campo["label"],$formType);
            } else if ($tipo === "wysiwyg") {
                $info_data = $this->getVisualEditorData($id,$campo["label"],$formType);                
            }

            $table_row .= "<tr>";
            $table_row .= $info_data;
            $table_row .= "</tr>";
        }

        return $table_row;
    }

    private function get_percent($base_percent, $value)
    {
        if ($base_percent > 0) {
            return sprintf("%.1f",(100 * $value) / $base_percent);
        }

        return $base_percent;
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

    public function getTotal($field_id, $formType, $value='')
    {
        if (is_string($field_id)) {
            if ($this->hasStateFilter()) {
                $key = "acolhesus_campo";
                $campo = $this->getState();
                $sql = "SELECT ID FROM $this->posts p INNER JOIN $this->postmeta pm ON p.ID=pm.post_id AND p.post_type='$formType' AND pm.meta_key='$key' AND pm.meta_value='$campo';";
                $id = $this->getSQLResults($sql,"row");
                if (is_object($id)) {
                    $entry = get_post_meta($id->ID, '_entry_id',true);
                    if ($entry) {
                        $sql = "SELECT value FROM " . $this->caldera_entries . " WHERE field_id='$field_id' AND entry_id=$entry";
                        $data = $this->getSQLResults($sql,"row");
                        if (is_object($data)) {
                            return $data->value;
                        } else {
                            return '-';
                        }
                    } else {
                        return '-';
                    }
                }
            } else {
                $sql = "SELECT COUNT(*) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id' AND value='$value'";
            }

            return $this->getSQLResults($sql, "row")->total;
        }
    }


    public function getAnswerToEspecific($field_id, $post_id)
    {
        global $wpdb;
        $_entry_id = get_post_meta($post_id, '_entry_id', true);
        $sql_current_values = "SELECT value as value FROM ".$wpdb->prefix."cf_form_entry_values WHERE entry_id='".$_entry_id."' AND field_id = '".$field_id."'";
        $result = $wpdb->get_results($sql_current_values, 'ARRAY_A');
        if(!empty($result))
            return $result[0]['value'];
        else return false;
    }

    public function getAnswerStats($field_id, $closed = false, $post_id = false)
    {
        if (is_string($field_id)) {
            if($post_id)
            {
                global $wpdb;
                $_entry_id = get_post_meta($post_id, '_entry_id', true);
                $sql_current_values = "SELECT value as value FROM ".$wpdb->prefix."cf_form_entry_values WHERE entry_id='".$_entry_id."' AND field_id = '".$field_id."'";
                return $wpdb->get_results($sql_current_values, 'ARRAY_A')[0]['value'];
            }else if ($closed) {
                $sql = "SELECT count(*) as total, value FROM " . $this->caldera_entries . " WHERE field_id='$field_id' GROUP BY value ORDER BY total DESC";
                return $this->getSQLResults($sql, "total");
            } else {
                $sql = "SELECT SUM(value) as total FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";
                return $this->getSQLResults($sql, "row")->total;
            }
        }

        return [];
    }

    public function getAnswer($field_id,$formType)
    {
        if ($this->hasStateFilter()) {
            $key = "acolhesus_campo";
            $campo = $this->getState();
            $sql = "SELECT ID FROM $this->posts p INNER JOIN $this->postmeta pm ON p.ID=pm.post_id AND p.post_type='$formType' AND pm.meta_key='$key' AND pm.meta_value='$campo';";
            $data = $this->getSQLResults($sql,"row");

            $sql = "SELECT meta_value as entry FROM $this->postmeta WHERE post_id=$data->ID AND meta_key='_entry_id'";
            $r = $this->getSQLResults($sql,"row");

            if (is_object($r)) {
                $sql = "SELECT value FROM $this->caldera_entries WHERE field_id='$field_id' AND entry_id='$r->entry'";
                $data = $this->getSQLResults($sql,"row");
            } else {
                $data = null;
            }

        } else {
            $sql = "SELECT entry_id, value FROM " . $this->caldera_entries . " WHERE field_id='$field_id'";
            $data = $this->getSQLResults($sql,"total");           
        }

        if (is_object($data)) {
            return $data->value;
        } else if (is_array($data)) {
            return $data;
        }

        return " --- ";
    }

    private function getFilterFor($type, $formType, $field_id, $value) {
        if ($this->getFase() === $type) {
            $key = "acolhesus_fase";
        } else if($this->getCampo() === $type) {
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

    public function getFilterForCharts($state, $phase, $formType, $field_id) {
        if(!empty($state))
        {
            $state_sql = "AND pm.meta_key='acolhesus_campo' AND pm.meta_value='".$state."'";
        }

        if(!empty($phase))
        {
            $phase_sql = "AND pm.meta_key='acolhesus_fase' AND pm.meta_value='".$phase."'";
        }

        $sql = "SELECT ID FROM $this->posts p INNER JOIN $this->postmeta pm ON p.ID=pm.post_id AND p.post_type='$formType' $state_sql $phase_sql;";
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
                $res = 0;
            }

            return $res;
        }
    }

    private function setSubQueryForState($formType, $entry) {
        $state = $this->getState();
        return $this->baseFilterQuery($this->getCampo(),$formType, $entry, $state);
    }

    private function setSubQueryForPhase($formType, $entry) {
        $phase = $this->getPhase();
        return $this->baseFilterQuery($this->getFase(),$formType, $entry, $phase);
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
            $state = $this->getState();
            $phase = $this->getPhase();

            $query = " INNER JOIN ". $this->postmeta ." as mta ON mta.post_id = p.ID 
                       INNER JOIN ". $this->postmeta ." as mtc ON mtc.post_id = p.ID 
                            WHERE p.post_type='$formType'
                            AND mta.meta_key='acolhesus_fase'  AND mta.meta_value='$phase'
                            AND mtc.meta_key='acolhesus_campo' AND mtc.meta_value='$state' ";

            $sql = $base_sql . $query . $sufix_sql;
        } else {
            if ($this->getFase() === $tipo) {
                $key = "acolhesus_fase";
            } else if ($this->getCampo() === $tipo) {
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