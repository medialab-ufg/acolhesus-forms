<?php
define('ACOLHESUS_URL', plugin_dir_url(__FILE__));

class AcolheSUSView {

    public function get_logo_URL()
    {
        return ACOLHESUS_URL . 'assets/images/logo-full.png';
    }

    public function get_title()
    {
        return 'Plataforma de Gestão AcolheSUS';
    }

    public function render_logo()
    {
        $src = $this->get_logo_URL();
        $alt = $title = "Logo " . $this->get_title();
        $_home_url = home_url('formularios-acolhesus');

        echo "<a href='$_home_url'> <img src='$src' alt='$alt' title='$title'/> </a>";
    }

}