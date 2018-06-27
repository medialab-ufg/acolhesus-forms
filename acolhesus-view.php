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

    public function renderFormsDenied() {
        echo '<center> Usuário sem permissão para acessar esta página! </center>';
    }

}