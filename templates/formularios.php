<?php
include_once( get_theme_file_path('header-full.php') );

if (!current_user_can('view_acolhesus')):
    $formView->renderFormsDenied();
else:
    global $AcolheSUS, $wp_query;
    $camposDoUsuario = $AcolheSUS->get_user_campos();
	$registered_forms = $AcolheSUS->forms;
	$user = wp_get_current_user()->display_name;
    ?>

    <div class="acolhesus-form-container col-md-12 lista-geral">

        <?php $formView->renderFormHeader(); ?>

		<div class="filters-wrapper">

            <?php $formView->renderWelcomeMessage($user); ?>

            <form method="GET" class="filtros acolhesus-filtros" id="forms-filter">
                <?php $formView->renderFilters(); ?>
            </form>

            <div class="col-md-12 btn-wrapper no-padding">
                <input class="btn btn-default filter-forms" type="submit" value="Filtrar" form="forms-filter"/>
            </div>
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
            // echo "<div class='col-md-12' style='text-align: center'>Formulários encontrados</div>";
            echo "<div class='col-md-12 acolhesus-forms-list $extra_class'>";
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
<?php
endif;

include_once( get_theme_file_path('footer-full.php') );