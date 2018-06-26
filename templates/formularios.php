<?php include_once( get_theme_file_path('header-full.php') ); ?>

<?php if (!current_user_can('view_acolhesus')): ?>
    <center> Permissão negada! </center>
<?php else:

    global $AcolheSUS, $wp_query;
    $camposDoUsuario = $AcolheSUS->get_user_campos();
	$registered_forms = $AcolheSUS->forms;
	$user = wp_get_current_user()->display_name;
    ?>

    <div class="acolhesus-form-container col-md-12 lista-geral">
        <h1 class="list-title"> <?php echo $AcolheSUS->get_title(); ?> </h1>
        <hr> <div class="logo-container"> <?php $AcolheSUS->render_logo(); ?> </div> <hr>

		<div class="filters-wrapper">
            <div class="welcome" style="color: black; text-align: center; margin-bottom: 20px">
                Olá, <strong><?php echo $user?></strong>! <br>
                Utilize os filtros abaixo para acessar os formulários
            </div>

            <form method="GET" class="filtros acolhesus-filtros" id="forms-filter">
                <h3 class="form-title"> Campos de Atuação</h3>
                <div>
                    <select name="campo" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
                        <option value="">Todos os campos</option>
                        <?php echo $AcolheSUS->get_campos_do_usuario_as_options( isset($_GET['campo']) ? $_GET['campo'] : '' ); ?>
                    </select>
                </div>
                <h3 class="form-title"> Fases </h3>
                <div>
                    <select name="fase" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
                        <option value="">Todas as fases</option>
                        <?php echo $AcolheSUS->get_fases_as_options( isset($_GET['fase']) ? $_GET['fase'] : '' ); ?>
                    </select>
                </div>

                <h3 class="form-title"> Eixos </h3>
                <div>
                    <select name="eixo" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
                        <option value="">Todos os eixos</option>
                        <?php echo $AcolheSUS->get_eixos_as_options( isset($_GET['eixo']) ? $_GET['eixo'] : '' ); ?>
                    </select>
                </div>

                <h3 class="form-title"> Formulários </h3>
                <div>
                    <select name="form" class="acolhesus_filter_forms" id="acolhesus_filter_forms_campos">
                        <option value="">Todos os formulários</option>
                        <?php echo $AcolheSUS->get_forms_as_options( isset($_GET['form']) ? $_GET['form'] : '' ); ?>
                    </select>
                </div>

            </form>

            <input class="btn btn-default" type="submit" value="Filtrar" form="forms-filter"/>
		</div>

        <?php
        /*
		 * TODO: Após aprovação do layout, refatorar esse código para devidas classes
		 * */
		if (isset($_GET['form']) && (!empty($_GET['form'])) && count($_GET) === 4 ) {
			$_form_filter = sanitize_text_field($_GET['form']);
			if ( array_key_exists($_form_filter, $registered_forms) ) {
				$registered_forms = [$_form_filter => $registered_forms[$_form_filter]];
			} else {
				$registered_forms = [];
				echo "<pre style='text-align: center'> Formulário inexistente! </pre>";
			}
		}

		$extra_class = (empty($_GET)) ? "default" : "filtered";
        if (!empty($_GET) && isset($_GET['form'])) {
            echo "<div class='acolhesus-forms-list $extra_class'>";
            foreach ($registered_forms as $formName => $formAtts):
                if ($AcolheSUS->can_user_see($formName)):
                    global $current_acolhesus_formtype;
                    $current_acolhesus_formtype = $formName;
                    $nome = $formAtts['labels']['name'];
                    $link = get_post_type_archive_link($formName);
                    $ver_todos = "Ir para " . $nome;

                    // Essa query é modificada pelo pre_get_posts que tem na classe principal do plugin
                    $wp_query = new WP_Query([
                        'post_type' => $formName,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                    ]);
                    ?>
                    <h3 class="form-title"> <?php echo $nome; ?> </h3>
                    <div class="panel">
                        <div class="ver-todos">
                            <a class="btn btn-default" href="<?php echo $link; ?>"> <?php echo $ver_todos; ?> </a>
                            <?php apply_filters('acolhesus_add_entry_btn', $current_acolhesus_formtype); ?>
                        </div>
                        <?php
                        if ($wp_query->found_posts > 0) {
                            include(plugin_dir_path(__FILE__) . "loop-forms.php");
                        } else {
                            echo "<center> Nenhuma resposta de $nome! </center>";
                        }
                        ?>
                    </div>
                    <?php
                endif;

            endforeach;
            echo "</div>";
        }
		?>
    </div>
<?php endif; ?>

<?php include_once( get_theme_file_path('footer-full.php') ); ?>