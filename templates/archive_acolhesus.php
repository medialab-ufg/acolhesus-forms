<?php
include_once( get_theme_file_path('header-full.php') );

global $current_acolhesus_formtype;
global $AcolheSUS;
$current_acolhesus_formtype = get_post_type();
$form = $AcolheSUS->forms[$current_acolhesus_formtype];

if ($AcolheSUS->can_user_see($current_acolhesus_formtype)): ?>

    <div class="acolhesus-form-container col-md-12">
        <h1 class="acolhesus-archive-title"> <?php echo post_type_archive_title('Formulário: '); ?> </h1>

        <a class="list-forms" href="<?php echo home_url('formularios-acolhesus'); ?>">&lt;&lt; Voltar para todos os formulários</a> <hr>

        <?php include_once( plugin_dir_path( __FILE__ ) . "loop-forms.php"); ?>

        <?php apply_filters('acolhesus_add_entry_btn', $current_acolhesus_formtype); ?>

        <br> <hr> <h3>Relatórios de Avaliação de Grupos</h3> <hr>
        <p>
            <?php
            $report = new AcolheSUSReports();
            $id = 'fld_7982129';


            foreach ($report->get_form_fields() as $id => $campo ) {
                if ( in_array($campo["type"], ["number", "filtered_select2"]) ) {
                    // echo $campo["label"] . "<br>";
                    echo $report->getAnswersFor($id) . " (10%) -- " .  $report->get_field_data($id)["label"] . " [filtre aqui]" . "<br>";
                }
            }

            ?>
        </p>

    </div>

<?php else:
    echo "<center> Sem permissões para ver o formulário " . $form['labels']['name'] . ". </center>";
endif;

include_once( get_theme_file_path('footer-full.php') );
