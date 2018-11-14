<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php
$post_type = get_post_type();
$post_id = get_the_ID();
$_sem_diligencias = ["avaliacao_grupos", "avaliacao_oficina","relatorio_oficina","memoria_reuniao", "atividades_dispersao"];
$_possui_diligencias = !in_array($post_type, $_sem_diligencias);
$_view_perm = "editar_" . $post_type;
$can_user_view = in_array($_view_perm, get_user_meta(get_current_user_id(), 'acolhesus_form_perms'));
$is_new_form = get_post_meta($post_id, 'new_form', true);

$forms_to_report = [
    'matriz_p_criticos',
    'matriz_cenario',
    'plano_trabalho'
];

$forms_chart = [
    'avaliacao_grupos',
    'avaliacao_oficina'
];

if ($is_new_form) {
    echo "<input type='hidden' name='novo_form' value='true'>";
}
?>

<div class="acolhesus-form-container">
    <input type="hidden" id="form_type" value="<?php echo $post_type;?>">
    <div class="options">
        <a href="<?php echo home_url('formularios-acolhesus'); ?>" class="btn btn-default voltar-home">
            VOLTAR PARA TELA INICIAL
        </a>

        <?php if (current_user_can('acolhesus_cgpnh')): ?>
            <a class="btn btn-default list-entries" href="<?php echo get_post_type_archive_link($post_type); ?>"> VER TODOS ESTADOS </a>
        <?php endif; ?>

        <div class="chart_options pull-right">
            <button id="show_form" class="btn btn-primary" style="display: none;" type="button">
                Ver formulário
            </button>
            <?php
            if(in_array($post_type, $forms_chart))
            {
                ?>
                <button id="gen_charts" class="btn btn-primary" type="button"> <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Gerar gráfico
                </button>
                <?php
            } else if(in_array($post_type, $forms_to_report))
            {
                if($post_type == 'plano_trabalho')
                {
                    ?>
                    <div class="btn-group gen-report">
                        <button id="gen_report" class="btn btn-primary" type="button"><i class="fa fa-file-text-o" aria-hidden="true"></i>
                            Gerar relatório
                        </button>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span> <span class="sr-only">Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li class="report_type" data-value="complete">
                                <a href="javascript:void (0);" >
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                    Completo
                                </a>
                            </li>
                            <li class="report_type" data-value="compact">
                                <a href="javascript:void (0);">
                                    <i class="fa fa-file-o" aria-hidden="true"></i>
                                    Compacto
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php
                }else {
                    ?>
                    <button id="gen_report" class="btn btn-primary" type="button"><i class="fa fa-file-text-o" aria-hidden="true"></i>
                        Gerar relatório
                    </button>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <h3>
        <span id="form-title"><?php the_title(); ?></span>

        <?php if (get_post_meta($post_id, 'locked', true)): ?>
            <span class="closed-form"> preenchimento encerrado </span>
        <?php endif; ?>
    </h3>

    <?php $formView->get_entry_attachments(); ?>

    <div id="the_content">
        <?php the_content(); ?>
    </div>
    <div id="charts_set">
        <input id="report_type" type="hidden" value="complete">
        <div id="chart"></div>
    </div>

    <div id="form-accordion">

        <?php if ($_possui_diligencias && (comments_open() || get_comments_number()) ) : ?>
            <h3> <?php echo $formView->getDiligencesTitle($post_type); ?> </h3>
            <div class="panel hidden-print">
                <div class="panel-footer panel-comentarios"> <?php comments_template(); ?> </div>
            </div>
        <?php endif; ?>

        <?php if ($can_user_view): ?>

            <h3> Histórico </h3>
            <div class="panel hidden-print">
                <div class="panel-footer panel-comentarios">
                    <?php
                    $log_opts = ['include_unapproved' => true, 'type' => 'acolhesus_log', 'post_id' => $post_id];
                    $logs = get_comments($log_opts);

                    if (count($logs) <= 0) {
                        echo "<p class='text-center'> Formulário ainda sem dados no histórico. </p>";
                    } else {
                        foreach ($logs as $log): ?>
                            <div class="acolhesus-log">
                                <?php echo '<strong>' . date('d/m/Y H:i', strtotime($log->comment_date)) . '</strong>'; ?>:
                                <?php echo $log->comment_content; ?>
                            </div>
                        <?php
                        endforeach;
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>