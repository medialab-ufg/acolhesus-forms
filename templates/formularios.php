<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada! </center>
<?php else:

    global $AcolheSUS, $wp_query;
    $camposDoUsuario = $AcolheSUS->get_user_campos();
    ?>

    <div class="acolhesus-form-container col-md-12 lista-geral">
        <h1 class="list-title"> <?php echo $AcolheSUS->get_title(); ?> </h1>
        <hr> <div class="logo-container"> <?php $AcolheSUS->render_logo(); ?> </div> <hr>

        <?php
        foreach ($AcolheSUS->forms as $formName => $formAtts):
        $wp_query = new WP_Query([
            'post_type' => $formName,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => 'acolhesus_campo',
                    'value' => $camposDoUsuario,
                    'compare' => 'IN'
                ]
            ]
        ]);
		
		?>
		<h3>
			<a href="<?php echo get_post_type_archive_link($formName); ?>"> <?php echo $formAtts['labels']['name']; ?> </a>
		</h3>
		<?php 
		global $current_acolhesus_formtype; $current_acolhesus_formtype = $formName;
		include( plugin_dir_path( __FILE__ ) . "loop-forms.php");
		
    endforeach;
    ?>
    </div>
<?php endif; ?>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>