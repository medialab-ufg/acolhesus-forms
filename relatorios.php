<?php
include_once (get_theme_file_path('header-full.php'));

if (current_user_can('administrator')) {
    global $AcolheSUS;
    if ($AcolheSUS->can_user_edit($form)):
        $report = new AcolheSUSReports();
        $view = new AcolheSUSView();
        date_default_timezone_set("America/Sao_Paulo");
    ?>
        <div class="acolhesus-form-container col-md-12" style="color: black">

            <a class="btn btn-default list-entries" href="<?php echo get_post_type_archive_link($form); ?>"> Voltar </a>

            <h3 class="text-center">Relatórios de <?php print_r( get_post_type_object($form)->label ); ?></h3>
            <h4 style="text-align: center;border-bottom: 1px solid; padding-bottom: 10px; margin-bottom: 30px">Resultados até <?php echo date("d/m/Y G:i") ?></h4>
            <div class="text-center">
                <form method="POST" class="reports acolhesus-reports" id="reports-filter" style="border-bottom: 1px solid #eaeaea; width: 100%; float: left; padding-bottom: 2%; margin-bottom: 2%;">
                    <div class="col-md-12">
                        <?php $view->renderFilters(false,false); ?>
                    </div>
                    <div class="col-md-12 btn-wrapper no-padding" style="margin-top: 20px">
                        <input class="btn btn-default btn-info filter-forms" type="submit" value="Gerar Relatório"/>
                    </div>
                </form>
            </div>

            <div style="margin-top: 2px;padding: 20px;">
                <?php
                $campo = $fase = null;
                if ($report->hasStateFilter()) {
                    $campo = sanitize_text_field($_POST["campo"]);
                }

                if ($report->hasPhaseFilter()) {
                    $fase = sanitize_text_field($_POST["fase"]);
                }

                $report->renderReports($form, $campo, $fase); ?>
            </div>
        </div>

<?php
    endif;
} else {
    echo "<p class='text-center'>Página não encontrada</p>";
}

include_once (get_theme_file_path('footer-full.php'));