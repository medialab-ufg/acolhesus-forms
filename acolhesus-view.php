<?php
define('ACOLHESUS_URL', plugin_dir_url(__FILE__));

class AcolheSUSView {

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

}