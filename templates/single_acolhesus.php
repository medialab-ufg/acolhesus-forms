<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php
$post_type = get_post_type();
$post_id = get_the_ID();
$_sem_diligencias = ["avaliacao_grupos", "avaliacao_oficina","relatorio_oficina","memoria_reuniao", "atividades_dispersao"];
$_possui_diligencias = !in_array($post_type, $_sem_diligencias);
$_view_perm = "editar_" . $post_type;
$can_user_view = in_array($_view_perm, get_user_meta(get_current_user_id(), 'acolhesus_form_perms'));
$is_new_form = get_post_meta($post_id, 'new_form', true);

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

        <button id="gen_charts" class="btn btn-primary" type="button"> <i class="fa fa-bar-chart" aria-hidden="true"></i>
            Gerar gráfico
        </button>
    </div>
    <h3>
        <?php the_title(); ?>

        <?php if (get_post_meta($post_id, 'locked', true)): ?>
            <span class="closed-form"> preenchimento encerrado </span>
        <?php endif; ?>
    </h3>

    <?php $formView->get_entry_attachments(); ?>

    <div id="the_content">
        <?php the_content(); ?>
    </div>
    <div id="chart"></div>

    <div id="form-accordion">

        <?php if ($_possui_diligencias && (comments_open() || get_comments_number()) ) : ?>
            <h3> Diligências </h3>
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