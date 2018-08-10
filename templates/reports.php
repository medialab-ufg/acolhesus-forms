
<a data-toggle="collapse" href="#relatorios" class="collapsed btn btn-default" aria-expanded="false"> Ver Relatórios </a>

<div id="relatorios" class="panel-collapse collapse" aria-expanded="false" style="color: black">
    <hr> <h3>Relatórios de Avaliação de Grupos</h3> <hr>

    <label for="campo">Campo:</label>
    <select name="" id="">
        <option value="todos">Todos os Campos</option>
    </select>
    <br>
    <label for="campo">Fase:</label>
    <select name="" id="">
        <option value="todos">Todas as Fases</option>
    </select>
    <br>
    <p style="margin-top: 2px; border: 1px solid rgba(227,227,227,0.8); padding: 20px;">
        <?php
        $report = new AcolheSUSReports();
        $id = 'fld_7982129';


        foreach ($report->get_form_fields() as $id => $campo ) {
            if ( in_array($campo["type"], ["number", "filtered_select2"]) ) {
                // echo $campo["label"] . "<br>";
                echo $report->getAnswersFor($id) . " (10%) -- - " . $campo["label"] . " :: " . $campo["slug"]  . "<br>";
            }
        }

        ?>
    </p>
</div>