<?php
define('ACOLHESUS_URL', plugin_dir_url(__FILE__));

class AcolheSUSView extends AcolheSUS {

    public $filtros = [
        'campo' => ['plural' => 'Todos os campos',      'singular' => 'Campo de Atuação'],
        'fase'  => ['plural' => 'Todas as fases',       'singular' => 'Fase'],
        'eixo'  => ['plural' => 'Todos os eixos',       'singular' => 'Eixo'],
        'form'  => ['plural' => 'Todos os formulários', 'singular' => 'Formulário']
    ];

    private function get_logo_URL()
    {
        return ACOLHESUS_URL . 'assets/images/logo-full.png';
    }

    private function get_title()
    {
        return 'Plataforma de Gestão AcolheSUS';
    }

    private function get_logo()
    {
        $src = $this->get_logo_URL();
        $alt = $title = "Logo " . $this->get_title();
        $_home_url = home_url('formularios-acolhesus');

        return "<a href='$_home_url'><img src='$src' alt='$alt' title='$title'/></a>";
    }

    public function renderFormHeader() {
        $header = '<h1 class="list-title">' . $this->get_title() . '</h1>';
        $header .= '<hr> <div class="logo-container">' . $this->get_logo() . '</div><hr>';

        echo $header;
    }

    public function renderWelcomeMessage($name = '') {
        $_header = "";
        if ($name && !empty($name)) {
            $_header =  'Olá, <span class="user-name">' . $name .'</span>!<br>';
        }

        echo '<div class="welcome">' . $_header . 'Utilize os filtros abaixo para acessar os formulários</div>';
    }

    public function renderFilters() {
        foreach ($this->filtros as $filtro => $props) {
            $opt = isset($_GET[$filtro]) ? $_GET[$filtro] : '';

            $html  = "<h3 class='form-title'>" . $props['singular'] . "</h3>";
            $html .= "<div><select name='$filtro' class='acolhesus_filter_forms' id='acolhesus_filter_forms_campos'>";
            $html .= "<option value=''>" . $props['plural'] . "</option>";
            $html .= $this->get_filter_options($filtro, $opt);
            $html .= "</select></div>";

            echo $html;
        }
    }

    public function filterSelectedForm(&$forms=[]) {
        if (isset($_GET['form']) && (!empty($_GET['form'])) && count($_GET) === 4 ) {
            $_form_filter = sanitize_text_field($_GET['form']);
            if (array_key_exists($_form_filter, $forms)) {
                $forms = [$_form_filter => $forms[$_form_filter]];
            } else {
                $forms = [];
                echo "<pre style='text-align: center'> Formulário inexistente! </pre>";
                return $forms;
            }
        }

        return $forms;
    }

    public function renderFormsLoop($forms) {
        global $AcolheSUS;
        foreach ($forms as $formName => $formAtts):
            if ($this->can_user_see($formName)):
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
                        include(plugin_dir_path(__FILE__) . "templates/loop-forms.php");
                    } else {
                        echo "<center> Nenhuma resposta de $nome! </center>";
                    }
                    ?>
                </div>
            <?php
            endif;

        endforeach;
    }

    public function renderFormsDenied() {
        echo '<center> Usuário sem permissão para acessar esta página! </center>';
    }

}