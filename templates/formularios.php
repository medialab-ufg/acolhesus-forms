<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada </center>
<?php else: ?>
    <div class="acolhesus-form-container col-md-12 lista-geral">
        <h1 style="text-align: center; color: black">Política Nacional de Humanização - Formulários Acolhe SUS </h1>
        <hr>

        <center>
            <img width="10%" src="http://redehumanizasus.net/wp-content/uploads/2017/09/logo-humanizasus-em-alta-300x231.jpg" />
        </center>

        <hr>
    
    <?php
    global $AcolheSUS, $wp_query;
    $camposDoUsuario = $AcolheSUS->get_user_campos();

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