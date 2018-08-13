<?php $report = new AcolheSUSReports();
$formType = get_post_type();
?>

<?php date_default_timezone_set("America/Sao_Paulo"); ?>
<hr>
<div id="relatorios" class="panel-collapse collapse" aria-expanded="false" style="color: black;">
    <h3 style="text-align: center">Relatórios de <?php echo post_type_archive_title(); ?></h3>
    <div style="text-align: center">Resultados até <?php echo date("d/m/Y G:i") ?></div>
    <br>
    <center>
        <label for="campo">Campo de Atuação:</label>
        <select name="" id="">
            <option value="todos">Todos os Campos de Atuação</option>
        </select>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="campo">Fase:</label>
        <select name="" id="">
            <option value="todos">Todas as Fases</option>
        </select>
        <br><br>
    </center>

    <div style="margin-top: 2px; border: 1px solid #d3d3d3; padding: 20px; background: #f3f3f3">
        <?php $report->renderReports($formType); ?>
    </div>
</div>