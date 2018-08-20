<?php
include_once (get_theme_file_path('header-full.php'));

if (current_user_can('administrator')) {
    global $AcolheSUS;
    if ($AcolheSUS->can_user_edit($form)):
        $report = new AcolheSUSReports();
        $view = new AcolheSUSView();
        date_default_timezone_set("America/Sao_Paulo");
        $form_type = get_post_type_object($form);
        $_hide_phase = !(isset($view->forms[$form_type->name]["uma_entrada_por_campo"]) && $view->forms[$form_type->name]["uma_entrada_por_campo"] );
    ?>
        <div class="acolhesus-form-container col-md-12 reports-wrapper">

            <a class="btn btn-default list-entries" href="<?php echo get_post_type_archive_link($form); ?>"> Voltar </a>

            <h3 class="text-center"> Relatórios de <?php echo $form_type->label; ?> </h3>
            <h4 class="text-center results-date">Resultados até <?php echo date("d/m/Y G:i") ?></h4>
            <div class="text-center">
                <form method="POST" class="reports acolhesus-reports" id="reports-filter">
                    <div class="col-md-12">
                        <?php $view->renderFilters(false,false,$_hide_phase); ?>
                    </div>
                    <div class="col-md-12 btn-wrapper no-padding">
                        <?php if (!$report->hasStateFilter() && !$report->hasPhaseFilter()) { ?>
                            <input type="reset" class="btn btn-default" form="reports-filter"  value="Limpar Filtros" />
                        <?php } ?>
                        <input type="submit" class="btn btn-default btn-info filter-forms" value="Gerar Relatório"/>
                    </div>
                </form>
            </div>

            <div class="report-results"> <?php $report->renderReports($form); ?> </div>

        </div>
<?php
    endif;
} else {
    echo "<p class='text-center'>Página não encontrada</p>";
}

include_once (get_theme_file_path('footer-full.php'));