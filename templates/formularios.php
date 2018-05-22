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


		<div class="panel panel-default">
			<div class="panel-body">
				Filtrar formulários:
				<form method="GET">
					<select name="campo" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
						<option value="">Todos os campos</option>
						<?php echo $AcolheSUS->get_campos_do_usuario_as_options( isset($_GET['campo']) ? $_GET['campo'] : '' ); ?>
					</select>
					<select name="fase" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
						<option value="">Todos as fases</option>
						<?php echo $AcolheSUS->get_fases_as_options( isset($_GET['fase']) ? $_GET['fase'] : '' ); ?>
					</select>
					<select name="eixo" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
						<option value="">Todos os eixos</option>
						<?php echo $AcolheSUS->get_eixos_as_options( isset($_GET['eixo']) ? $_GET['eixo'] : '' ); ?>
					</select>
					<input type="submit" value="Filtrar" />
				</form>
			</div>
		</div>


        <?php
        foreach ($AcolheSUS->forms as $formName => $formAtts):
            if ($AcolheSUS->can_user_see($formName)):
                global $current_acolhesus_formtype;
                $current_acolhesus_formtype = $formName;

                // Essa query é modificada pelo pre_get_posts que tem na classe principal do plugin
                $wp_query = new WP_Query([
                    'post_type' => $formName,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                ]);
        ?>
                <h3 class="form-title">
                    <a href="<?php echo get_post_type_archive_link($formName); ?>"> <?php echo $formAtts['labels']['name']; ?> </a>
                </h3>
			<?php
                include( plugin_dir_path( __FILE__ ) . "loop-forms.php");
            endif;
        endforeach;
    ?>
    </div>
<?php endif; ?>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>