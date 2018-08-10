<?php date_default_timezone_set("America/Sao_Paulo"); ?>
<a data-toggle="collapse" href="#relatorios" class="collapsed btn btn-default" aria-expanded="false"> Ver Relatórios </a>

<div id="relatorios" class="panel-collapse collapse" aria-expanded="false" style="color: black">
    <hr>
    <h3 style="text-align: center">Relatórios de Avaliação de Grupos</h3>
    <div style="text-align: center">Resultados até <?php echo date("d/m/Y G:i") ?></div>
    <br>
    <center>
        <label for="campo">Campo:</label>
        <select name="" id="">
            <option value="todos">Todos os Campos</option>
        </select>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="campo">Fase:</label>
        <select name="" id="">
            <option value="todos">Todas as Fases</option>
        </select>
        <br><br>
    </center>

    <p style="margin-top: 2px; border: 1px solid #d3d3d3; padding: 20px;">
        <?php
        $report = new AcolheSUSReports();
        $id = 'fld_7982129';

        $c = 0;
        $total_geral = 0;
        foreach ($report->get_form_fields() as $id => $campo ) {
            // "filtered_select2"
            if ( in_array($campo["type"], ["number"]) ) {
                echo intval($report->getAnswersFor($id)) . " - <span><i><small>" . $campo["label"] . "</small></i></span><br>";
                if ($campo["type"] === "number") {

                    if ($c === 4) {
                        echo "<br>"; // $total_geral
                        $c = -1;
                        $total_geral = 0;
                    } else {
                        $total_geral += intval($report->getAnswersFor($id));
                    }

                    $c++;
                }

            }
        }

        ?>
    </p>
</div>