<?php
include_once( get_theme_file_path('header-full.php') );

global $current_acolhesus_formtype;
global $AcolheSUS;
$current_acolhesus_formtype = get_post_type();

$form = $AcolheSUS->forms[$current_acolhesus_formtype];
?>

<div class="acolhesus-form-container col-md-12">
<!--
    <?php if(current_user_can('acolhesus_cgpnh')): ?>
    <div class="forms-info">
        <center>
            <strong> Fase: </strong><?php echo $form['fase']; ?> <br>
            <?php echo isset($form['eixo']) ? "<strong>Eixo:</strong> " . $form['eixo'] : ""; ?>
        </center>
    </div>
    <?php endif; ?>
-->
    <h1 class="acolhesus-archive-title">
        <?php echo post_type_archive_title('Formulário: '); ?>
        <?php
        /*
        if (current_user_can('acolhesus_cgpnh')): ?>

            <?php if ($AcolheSUS->is_form_locked($current_acolhesus_formtype)): ?>
                <span style="color: red; font-size: 12px; float: right; margin-right: 10px;">Fechado</span>
            <?php else: ?>
                <input type="hidden" id="current_post_type" name="current_post_type" value="<?php echo $current_acolhesus_formtype; ?>">
                <button class="btn btn-default btn-warning" style="float: right; margin-right: 10px;">
                    <a id="close_form" style="color: black" href="javascript:void(0)"> FECHAR EDIÇÃO </a>
                </button>
            <?php endif; ?>

        <?php endif;
        */ ?>
    </h1>
	<a href="<?php echo home_url('formularios-acolhesus'); ?>">&lt;&lt;Voltar para todos os formulários</a>
    <hr>

	<?php include_once( plugin_dir_path( __FILE__ ) . "loop-forms.php"); ?>

</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>