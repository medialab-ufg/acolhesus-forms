<?php
define('ACOLHESUS_URL', plugin_dir_url(__FILE__));

include "acolhesus-reports.php";

class AcolheSUSView extends AcolheSUS {

    public $filtros = [
        'campo' => ['plural' => 'Todos os campos',      'singular' => 'Campo de Atuação'],
        'fase'  => ['plural' => 'Todas as fases',       'singular' => 'Fase'],
        'eixo'  => ['plural' => 'Todos os eixos',       'singular' => 'Eixo'],
        'form'  => ['plural' => 'Todos os formulários', 'singular' => 'Formulário']
    ];


    function __construct()
    {
        // Construtor vazio para evitar repetir as operações da classe pai
    }

    private function get_logo_URL()
    {
        return ACOLHESUS_URL . 'assets/images/logo-full.png';
    }

    private function get_title()
    {
        return 'Plataforma de Gestão AcolheSUS';
    }

    private function get_home_URL()
    {
       return home_url('formularios-acolhesus');
    }

    private function get_logo()
    {
        $src = $this->get_logo_URL();
        $alt = $title = "Logo " . $this->get_title();
        $_home_url = $this->get_home_URL();

        return "<a href='$_home_url'><img src='$src' alt='$alt' title='$title'/></a>";
    }

    public function renderFormHeader() {
        $URL = $this->get_home_URL();

        $header = "<h1 class='list-title'> <a href='$URL'>" . $this->get_title() . "</a></h1>";
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


    public function renderFilters($showForms = true, $showAxis = true, $showPhase = true) {
        $filtros = $this->filtros;
        if (!$showForms) {
            array_pop($filtros);
        }

        if (!$showAxis) {
            array_pop($filtros);
        }

        if (!$showPhase) {
            array_pop($filtros);
        }

        foreach ($filtros as $filtro => $props) {

            // Manter assim apenas até deliberar sobre layout dos relatórios
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $opt = (isset($_POST[$filtro]) ) ? $_POST[$filtro] : '';
            } else {
                $opt = (isset($_GET[$filtro]) ) ? $_GET[$filtro] : '';
            }

            $_filtered = $this->get_filter_selected($filtro, $opt);

            $html = "";
            $style = "";

            if (!$showForms) {
                $_filtered = "";
                $style = "style='font-size: 20px; margin-bottom: 10px; color: black'";
                $class = 4;
                if (!$showAxis)
                    $class = 6;
                if (!$showPhase)
                    $class = 12;

                $html .= "<div class='col-md-$class'>";
            }

            $html .= "<h3 class='form-title' $style>" . $props['singular'] . " <span class='used_filter'>" . $_filtered . " </span></h3>";
            $html .= "<div><select name='$filtro' class='acolhesus_filter_forms' id='acolhesus_filter_forms_campos'>";
            $html .= "<option value=''>" . $props['plural'] . "</option>";
            $html .= $this->get_filter_options($filtro, $opt);
            $html .= "</select></div>";

            if (!$showForms) {
                $html .= "</div>";
            }

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
                echo "<pre class='text-center'> Formulário inexistente! </pre>";
                return $forms;
            }
        }

        return $forms;
    }

    public function filterSelectedPhase(&$forms=[]) {
        if (isset($_GET['fase']) && !empty($_GET['fase'])) {
            $phase = sanitize_text_field($_GET['fase']);
            if (in_array($phase, array_keys($this->fases))) {
                $forms = array_filter($forms, function($form) {
                    return ($form["fase"] === sanitize_text_field($_GET['fase']));
                });
            }
        }

        return $forms;
    }

    public function filterSelectedAxis(&$forms=[]) {
        if (isset($_GET['eixo']) && !empty($_GET['eixo'])) {
             $eixo = sanitize_text_field($_GET['eixo']);
             if (in_array($eixo, $this->eixos)) {
                 $forms = array_filter($forms, function($f) { return $f["eixo"] === "todos"; });
            }
        }

        return $forms;
    }

    public function noForms() {
        echo "<p class='no-forms-found'> Nenhum formulário encontrado para os filtros selecionados. </p>";
    }

    public function renderFormsDenied() {
        echo '<p class="text-center"> Usuário sem permissão para acessar esta página! </p>';
    }

    function get_entry_attachments() {
        add_filter('caldera_forms_render_get_field_type-advanced_file', array(&$this, 'render_form_attachments'),20);
    }

    function render_form_attachments($field) {
        if (isset($field['type']) && "advanced_file" === $field['type']) {
            $anexos = $this->get_attachments($field["ID"]);
            if (is_array($anexos)) {
                echo "<ul class='form_attachments cf-adv-preview-list'>";
                    array_map(function($e) { $this->attach_style($e['id'],$e['value']); }, $anexos);
                echo "</ul>";
            }
        }

        return $field;
    }

    private function attach_style($id,$url) {
        if (!empty($id) && !empty($url)) {
            $filename = basename($url);
            ?>
            <li class="cf-uploader-queue-item attach-<?php echo $id; ?>">
                <a href="javascript:void(0)"class="acolhesus-remove-file"
                   data-id="<?php echo $id; ?>" data-name="<?php echo $filename; ?>">&times;</a>
                <a href="<?php echo $url; ?>" class="acolhesus-file-name"> <?php echo $filename; ?> </a>
            </li>
            <?php
        }
    }

}
