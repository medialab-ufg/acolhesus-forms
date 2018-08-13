<?php $report = new AcolheSUSReports();
$formType = get_post_type();
?>

<?php date_default_timezone_set("America/Sao_Paulo"); ?>
<hr>
<div id="relatorios" class="panel-collapse collapse" aria-expanded="false" style="color: black;">
    <h3 style="text-align: center">Relatórios de <?php echo post_type_archive_title(); ?></h3>
    <div style="text-align: center">Resultados até <?php echo date("d/m/Y G:i") ?></div>
    <br>
    <div class="text-center">
        <form method="POST" class="reports acolhesus-reports" id="reports-filter">
            <?php $formView->renderFilters(false); ?>
        </form>

        <div class="col-md-12 btn-wrapper no-padding">
            <br>
            <input class="btn btn-default filter-forms" type="submit" value="Gerar" form="reports-filter"/>
        </div>

    </div>

    <hr>

    <div style="margin-top: 2px;padding: 20px;">
        <?php
        $campo = null;
        if (isset($_POST["campo"]) && strlen($_POST["campo"]) === 2 ) {
            $campo = sanitize_text_field($_POST["campo"]);
        }

         $report->renderReports($formType, $campo); ?>
    </div>
</div>