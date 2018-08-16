<?php
include_once (get_theme_file_path('header-full.php'));

if (current_user_can('administrator')) {
    global $AcolheSUS;
    if ($AcolheSUS->can_user_edit($form)):
        $report = new AcolheSUSReports();
        $view = new AcolheSUSView();
        date_default_timezone_set("America/Sao_Paulo");
    ?>
        <hr>
        <div class="acolhesus-form-container col-md-12">
            <h3 style="text-align: center">Relatórios de <?php print_r( get_post_type_object($form)->label ); ?></h3>
            <h4 style="text-align: center">Resultados até <?php echo date("d/m/Y G:i") ?></h4>
            <br>
            <div class="text-center">
                <form method="POST" class="reports acolhesus-reports" id="reports-filter"
                      style="background: #eaeaea; width: 100%; float: left;padding: 4% 0 5% 0;">
                    <div class="col-md-12">
                        <?php $view->renderFilters(false); ?>
                    </div>
                </form>

                <div class="col-md-12 btn-wrapper no-padding">
                    <br>
                    <input class="btn btn-default filter-forms" type="submit" value="Gerar Relatórios" form="reports-filter"/>
                </div>

            </div>

            <hr>

            <div style="margin-top: 2px;padding: 20px;">
                <?php
                $campo = null;
                if (isset($_POST["campo"]) && strlen($_POST["campo"]) === 2) {
                    $campo = sanitize_text_field($_POST["campo"]);
                }

                $report->renderReports($form, $campo); ?>
            </div>
        </div>

<?php
    endif;
} else {
    echo "<p class='text-center'>Página não encontrada</p>";
}

include_once( get_theme_file_path('footer-full.php') );