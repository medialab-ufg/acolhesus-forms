<?php
include_once( get_theme_file_path('header-full.php') );
global $AcolheSUS;

if (!$AcolheSUS->isRespondent()):
    $formView->renderFormsDenied();
else:
    global $wp_query;
	$forms = $AcolheSUS->forms;
	$user = wp_get_current_user()->display_name;
    ?>

    <div class="acolhesus-form-container col-md-12 lista-geral">

        <?php $formView->renderFormHeader(); ?>

		<div class="filters-wrapper">

            <?php $formView->renderWelcomeMessage($user); ?>

            <form method="GET" class="filtros acolhesus-filtros" id="forms-filter">
                <?php $formView->renderFilters(); ?>
            </form>

            <?php if ($formView->user_can_see_states()): ?>
                <div class="col-md-12 btn-wrapper no-padding">
                    <input class="btn btn-default filter-forms" type="submit" value="Filtrar" id="dofilter" form="forms-filter"/>
                </div>
            <?php endif; ?>

		</div>

        <?php
        if (!$formView->user_can_see_states()) { ?>
            <p class="text-center" style="color: black; margin-top: 40px">
                Nenhum campo de atuação configurado para este usuário. Favor entrar em contato com equipe da CGPNH.
            </p>
        <?php
        } else {
            $formView->filterSelectedForm($forms);

            $formView->filterSelectedPhase($forms);

            $formView->filterSelectedAxis($forms);

            $extra_class = (empty($_GET)) ? "default" : "filtered";
            if (!empty($_GET) && isset($_GET['form'])) {
                echo "<div class='col-md-12 acolhesus-forms-list $extra_class'>";
                if (empty($forms)) {
                    $formView->noForms();
                } else {
                    foreach ($forms as $formName => $formAtts):
                        if ($AcolheSUS->can_user_see($formName) && $formAtts['slug'] !== 'poster'):
                            global $current_acolhesus_formtype;
                            $current_acolhesus_formtype = $formName;
                            $nome = $formAtts['labels']['name'];
                            $link = get_post_type_archive_link($formName);
                            $ver_todos = $formView->getFormLinkText($formName,$formAtts);

                            if (!empty(get_user_meta(get_current_user_id(), 'acolhesus_campos'))) {
                                // Essa query é modificada pelo pre_get_posts que tem na classe principal do plugin
                                $wp_query = new WP_Query([
                                    'post_type' => $formName,
                                    'post_status' => 'publish',
                                    'posts_per_page' => -1,
                                ]);
                            }
                            $formEntries = $wp_query->found_posts;
                            ?>
                            <h3 class="form-title"> <?php echo $nome; ?> </h3>
                            <div class="panel">

                                <div class="ver-todos">
                                    <?php apply_filters('acolhesus_add_entry_btn', $current_acolhesus_formtype); ?>
                                </div>

                                <?php if ($formEntries > 0): ?>
                                    <div class="ver-todos">
                                        <a class="btn btn-default" href="<?php echo $link;?>"><?php echo $ver_todos;?></a>
                                    </div>
                                <?php
                                    include(plugin_dir_path(__FILE__) . "loop-forms.php");
                                    else:
                                        echo "<div class=\"clear\"></div> <p class='text-center'> Nenhuma resposta de $nome! </p>";
                                    endif;
                                    ?>
                            </div>
                        <?php
                        endif;
                    endforeach;
                }
                echo "</div>";
            }
        }
		?>
    </div>
<?php
endif;

include_once( get_theme_file_path('footer-full.php') );