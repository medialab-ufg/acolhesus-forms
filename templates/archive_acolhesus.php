<?php include_once( get_theme_file_path('header-full.php') ); ?>

<div class="acolhesus-form-container col-md-12">
    <h1 class="acolhesus-archive-title"> <?php echo post_type_archive_title('Formulário: '); ?> </h1>

	<?php global $current_acolhesus_formtype; $current_acolhesus_formtype = get_post_type(); ?>
	<?php include_once( plugin_dir_path( __FILE__ ) . "loop-forms.php"); ?>

</div>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>