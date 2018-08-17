<?php
include_once( get_theme_file_path('header-full.php') );

global $current_acolhesus_formtype;
global $AcolheSUS;
$current_acolhesus_formtype = get_post_type();
$form = $AcolheSUS->forms[$current_acolhesus_formtype];

if ($AcolheSUS->can_user_see($current_acolhesus_formtype)): ?>

    <div class="acolhesus-form-container col-md-12">
        <h1 class="acolhesus-archive-title">
            <?php echo post_type_archive_title('Formulário: '); ?>

            <?php if (current_user_can('administrator') && $AcolheSUS->can_user_edit($current_acolhesus_formtype)) { ?>
                <a href="relatorio" class="btn btn-default btn-info abrir-relatorios" style="float: right"> Ver Relatórios </a>
            <?php }?>
        </h1>

        <a class="list-forms" href="<?php echo home_url('formularios-acolhesus'); ?>">&lt;&lt; Voltar para tela inicial</a> <hr>

        <div id="lista-formularios">
            <?php include_once( plugin_dir_path( __FILE__ ) . "loop-forms.php"); ?>

            <?php apply_filters('acolhesus_add_entry_btn', $current_acolhesus_formtype); ?>
        </div>
    </div>

<?php else:
    echo "<p class='text-center'> Sem permissões para ver o formulário " . $form['labels']['name'] . ". </p>";
endif;

include_once( get_theme_file_path('footer-full.php') );
