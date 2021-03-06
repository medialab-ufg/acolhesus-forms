<?php
include_once (get_theme_file_path('header-full.php'));

global $AcolheSUS;

if ($AcolheSUS->isCGPNH()) {
    if ($AcolheSUS->can_user_edit($form)):
        $report = new AcolheSUSReports();
        $view = new AcolheSUSView();
        date_default_timezone_set("America/Sao_Paulo");
        $form_type = get_post_type_object($form);
        $label = $form_type->label;
        $_hide_phase = !(isset($view->forms[$form_type->name]["uma_entrada_por_campo"]) && $view->forms[$form_type->name]["uma_entrada_por_campo"] );
    ?>
    <div class="row">
        <div class="acolhesus-form-container col-md-12 reports-wrapper">

            <a class="btn btn-default list-entries hidden-print" href="<?php echo get_post_type_archive_link($form); ?>"> Voltar </a>

            <h3 class="text-center"> Relatórios de <?php echo $label; ?> </h3>
            <h4 class="text-center results-date">Resultados até <?php echo date("d/m/Y G:i") ?></h4>
            <div class="text-center">
                <form method="POST" class="reports acolhesus-reports" id="reports-filter">
                    <div class="col-md-12">
                        <?php $view->renderFilters(false,false,$_hide_phase); ?>
                    </div>
                    <div class="col-md-12 btn-wrapper no-padding">
                        <?php if (!$report->hasStateFilter() && !$report->hasPhaseFilter()) { ?>
                            <input type="reset" class="btn btn-default hidden-print" form="reports-filter"  value="Limpar Filtros" />
                        <?php } ?>
                        <input type="submit" class="btn btn-info filter-forms hidden-print" value="Gerar Relatório"/>

                        <?php
                        $both_charts = [
                            'avaliacao_grupos',
                            'avaliacao_oficina'
                        ];

                        $pie_chart = [
                            'matriz_cenario'
                        ];

                        $line_chart = [
                            'ind_materno_infantil',
                            'indicadores_caps',
                            'indicadores',//Indicadores Hospital Geral
                            'indicadores_basica'
                        ];

                        if(in_array($form, $both_charts) || in_array($form, $pie_chart) || in_array($form, $line_chart))
                        {
                            ?>
                            <div class="btn-group">
                                <button type="button" id="gen_charts" class="btn btn-primary filter-forms hidden-print">Gerar Gráfico</button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span> <span class="sr-only">Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">

                                    <!--PIE CHART-->
                                    <?php if(in_array($form, $both_charts) || in_array($form, $pie_chart)){ ?>
                                    <li class="chart_type" data-value="pie"><a href="javascript:void (0);" > <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                            Pizza
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <!--BAR CHART-->
                                    <?php if(in_array($form, $both_charts)) { ?>
                                        <li class="chart_type" data-value="bar">
                                            <a href="javascript:void (0);">
                                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                Barras
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <!--Line chart-->
                                    <?php if(in_array($form, $line_chart)) { ?>
                                        <li class="chart_type" data-value="line">
                                            <a href="javascript:void (0);">
                                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                                                Linhas
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="report-results col-md-12">
                    <?php
                    if($form === 'matriz_p_criticos'){
                        $report->renderMatrizCriticosReport($form, $label);
                    }
                    else {
                        $report->renderReports($form,$label);
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="chart_type" value="pie">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
<?php
    endif;
} else {
    echo "<p class='text-center'> Relatório indisponível!</p>";
}

include_once (get_theme_file_path('footer-full.php'));