<?php
/**
 * Plugin Name: Formulários para AcolheSUS RHS
 * Plugin URI: https://github.com/medialab-ufg/acolhesus-forms
 * Description: Formulários customizados para aplicação da CGPNH
 * Author: L3P/UFG
 * Version: 0.1
 * Author URI: https://github.com/medialab-ufg/
 * Text Domain: acolhesus-rhs
 */

define('ACOLHESUS_URL', plugin_dir_url(__FILE__));

/*
 * Inicialmente, depende de https://br.wordpress.org/plugins/caldera-forms/ (versao free)
 */

class AcolheSUS {

    public $campos = [
        'AC',
        'AL',
        'AM',
        'AP',
        'BA',
        'CE',
        'DF',
        'ES',
        'GO',
        'MA',
        'MG',
        'MS',
        'MT',
        'PA',
        'PB',
        'PE',
        'PI',
        'PR',
        'RJ',
        'RN',
        'RO',
        'RR',
        'RS',
        'SC',
        'SE',
        'SP',
        'TO'
    ];

    public $fases = [
        '| - Análise Situacional',
        '|| - Elaboração do Plano de Intervenção',
        '||| - Monitoramento da Implementação do Plano de Trabalho',
        'Macrogestão'
    ];

    public $eixos = [
        'Acolhimento',
        'Qualificação Profissional',
        'Gestão de Processos de Trabalho',
        'Organização do Cuidado',
        'Ambiência'
    ];

    public $forms = [
        'matriz_cenario' => [
            'labels' => [
                'name' => 'Matriz de Cenário',
                'singular_name' => 'Formulário de Matriz de Cenário'
            ],
            'form_id' => '', // Setado via admin
            'slug' => 'matriz_cenario',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => 0
        ],
        'avaliacao_grupos' => [
            'labels' => [
                'name' => 'Avaliações dos Grupos',
                'singular_name' => 'Atuação do Grupo'
            ],
            'slug' => 'avaliacao_grupos',
            'uma_entrada_por_campo' => false,
            'fase' => 0

        ]
    ];
    
    function __construct() {

        add_action('init', [&$this, 'register_post_types']);
        add_action('init', [&$this, 'init_default_data']);

        add_filter('the_content', [&$this, 'filter_the_content']);

        add_action('caldera_forms_entry_saved', [&$this, 'saved_entry'], 10, 3);

        add_action('wp_enqueue_scripts', [&$this, 'load_acolhesus_assets']);

        add_filter('archive_template', [&$this, 'acolhesus_archive_page']);
        add_filter('single_template', [&$this, 'acolhesus_single_page']);

        add_action( 'generate_rewrite_rules', array( &$this, 'rewrite_rules' ), 10, 1 );
        add_filter( 'query_vars', array( &$this, 'rewrite_rules_query_vars' ) );
        add_filter( 'template_include', array( &$this, 'rewrite_rule_template_include' ) );

        add_action('template_redirect', array(&$this, 'can_user_view_form'));

        add_action('wp_ajax_acolhesus_save_post_basic_info', array(&$this, 'ajax_callback_save_post_basic_info'));

        add_action('wp_ajax_acolhesus_add_form_entry', array(&$this, 'ajax_callback_add_form_entry'));

        add_action('wp_ajax_acolhesus_lock_form', array(&$this, 'ajax_callback_lock_form'));

        add_action('wp_ajax_toggle_lock_single_form', array(&$this, 'toggle_lock_form_entries'));

        add_action('wp_ajax_unlock_single_form', array(&$this, 'unlock_form_entries'));

        add_action('pre_get_posts', array(&$this, 'return_all_user_entries'));

        $this->set_forms_phases();
    }

    private function set_forms_phases() {
        $this->forms['matriz_cenario']['fase'] = $this->fases[0];
        $this->forms['matriz_cenario']['eixo'] = $this->eixos[0];
        $this->forms['avaliacao_grupos']['fase'] = $this->fases[0];
        $this->forms['avaliacao_grupos']['eixo'] = $this->eixos[0];
    }

    function init_default_data() {
        global $AcolheSUSAdminForm;
        // Populate form IDs
        $form_ids = $AcolheSUSAdminForm->get_acolhesus_option('form_ids');

        foreach ($this->forms as $formName => $form) {
            
            $formID = isset($form_ids[$formName]) ? $form_ids[$formName] : '';
            $this->forms[$formName]['form_id'] = $formID;

            // Cria uma entrada pra cada campo(UF) quando for o caso
            if (isset($form['uma_entrada_por_campo']) && $form['uma_entrada_por_campo']) {
                if ($this->didnt_do_yet('criar_campo_form_' . $formName)) {
                    foreach ($this->campos as $uf) {
                        $title = $form['labels']['singular_name'] . " ({$uf})";
                        $metas = [
                            'acolhesus_campo' => $uf,
                            'acolhesus_eixo', $form['eixo'],
                            'acolhesus_fase', $form['fase']
                        ];
                        $this->add_acolhesus_entry($title, $formName, 'publish', $metas);
                    }
                }
            }

        }

    }

    private function add_acolhesus_entry($title, $type, $status, $metas = []) {
        $post = ['post_title' => $title, 'post_type' => $type, 'post_status' => $status];
        $new_id = wp_insert_post($post);
        foreach ($metas as $_meta_key => $value) {
            add_post_meta($new_id, $_meta_key, $value);
        }

        return $new_id;
    }
    
    function register_post_types() {
        
        foreach ($this->forms as $formName => $form) {
            
            register_post_type($formName, array(
                'labels' => $form['labels'],
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => $form['slug']),
                'capability_type' => 'post',
                'menu_position' => 20,
                'supports' => [
                    'comments'
                ]
            ));

        }

    }

    function set_acolhesus_readonly($attrs, $field, $form) {
        $_readonly_fields = ["text", "textarea", "number", "hidden", "paragraph"];
        $field_type = Caldera_Forms_Field_Util::get_type($field, $form);

        if (in_array($field_type, $_readonly_fields)) {
            $attrs['readonly'] = 'readonly';
        } else if ($field_type === "dropdown") {
            $attrs['disabled'] = 'disabled';
        }

        if (empty($attrs["value"]) && ("text" === $field_type || "paragraph" === $field_type)) {
            $attrs["value"] = "--------";
        }

        return $attrs;
    }

    function acolhesus_readonly_classes($wrapper_classes) {
        $wrapper_classes[] = "acolhesus-readonly";

        return $wrapper_classes;
    }

    function filter_the_content($content) {
        global $post;
        $formType = get_post_type();

        if (is_single()) {
            if (!$this->can_user_see($formType)) {
                echo "<div class='user-cant-see'> Sem permissão para ver as respostas de " . get_the_title() . "</div>";

                return;
            }

            $this->render_locked_form($post->ID, $formType);
        }

        $saved_form_id = get_post_meta($post->ID, '_entry_id', true);
        $form = "";

        if (isset($this->forms[$formType])) {
            if ( true !== $this->forms[$formType]['uma_entrada_por_campo'] ) {
                $form .= $this->get_basic_info_form();
            }
        }

        $content .= "Fase " . $this->forms[$formType]['fase'];
        $content .= "Eixo " . $this->forms[$formType]['eixo'];

        if (array_key_exists($post->post_type, $this->forms)) {

            $caldera_plugin = get_class_methods(Caldera_Forms::class );

            if (is_array($caldera_plugin) && in_array("render_form", $caldera_plugin)) {

                $entry_id = ($saved_form_id) ? $saved_form_id : null;
                $form .= Caldera_Forms::render_form([
                    'id' => $this->forms[$post->post_type]['form_id'], 
                ], $entry_id);
            }
        }

        return $content . " <br>" . $form;
    }

    private function is_entry_locked($entry_id) {
        return get_post_meta($entry_id, "locked", true);
    }

    private function render_locked_form($form_id, $post_type) {
        if ($this->is_entry_locked($form_id) || !$this->can_user_edit($post_type) ) {
            add_filter('caldera_forms_field_attributes', array(&$this, 'set_acolhesus_readonly'), 20, 3);
            add_filter('caldera_forms_render_form_wrapper_classes', array(&$this, 'acolhesus_readonly_classes'), 20);
        }
    }
	
	function get_campos_do_usuario_as_options($selected = '') {
		$camposDoUsuario = $this->get_user_campos();
		$options = '';
		foreach ($camposDoUsuario as $campo) {
            $options .= "<option value='$campo'";
            $options .= selected($selected, $campo, false);
            $options .= ">$campo</option>\n";
        }
		return $options;
	}
	
	function get_eixos_as_options($selected = '') {
		$options = '';
		foreach ($this->eixos as $eixo) {
            $options .= "<option value='$eixo'";
            $options .= selected($selected, $eixo, false);
            $options .= ">$eixo</option>\n";
        }
		return $options;
	}
	function get_fases_as_options($selected = '') {
		$options = '';
		foreach ($this->fases as $fase) {
            $options .= "<option value='$fase'";
            $options .= selected($selected, $fase, false);
            $options .= ">$fase</option>\n";
        }
		return $options;
	}
	
    private function get_basic_info_form() {
        global $post;
        
        
        $campoAtual = get_post_meta($post->ID, 'acolhesus_campo', true);
        $faseAtual = get_post_meta($post->ID, 'acolhesus_fase', true);
        $eixoAtual = get_post_meta($post->ID, 'acolhesus_eixo', true);

        $options = $this->get_campos_do_usuario_as_options($campoAtual);

        $title = '<h2>Campo de atuação</h2>';

        $camposHtml = "$title<select id='acolhesus_campo_selector' class='acolhesus_basic_info_selector' name='acolhesus_campo' data-post_id='{$post->ID}'>$options</select>";
		
		$options = $this->get_fases_as_options($faseAtual);
		$title = '<h2>Fase</h2>';

        $faseHtml = "$title<select id='acolhesus_fase_selector' class='acolhesus_basic_info_selector' name='acolhesus_fase' data-post_id='{$post->ID}'>$options</select>";
		
		$options = $this->get_eixos_as_options($eixoAtual);
		$title = '<h2>Eixo</h2>';

        $eixoHtml = "$title<select id='acolhesus_eixo_selector' class='acolhesus_basic_info_selector' name='acolhesus_eixo' data-post_id='{$post->ID}'>$options</select>";
		
		return $camposHtml . $faseHtml . $eixoHtml;

    }

    function ajax_callback_save_post_basic_info() {
        
        if (isset($_POST['acolhesus_campo']) && $_POST['post_id']) {
            update_post_meta($_POST['post_id'], 'acolhesus_campo', $_POST['acolhesus_campo']);
            update_post_meta($_POST['post_id'], 'acolhesus_fase', $_POST['acolhesus_fase']);
            update_post_meta($_POST['post_id'], 'acolhesus_eixo', $_POST['acolhesus_eixo']);
        }

        die;
    }

    function ajax_callback_add_form_entry() {
        $user_campos = $this->get_user_campos();
        if (is_array($user_campos) && count($user_campos) > 0) {
            $metas = [ 'acolhesus_campo' => array_shift($user_campos)];
            $_id = $this->add_acolhesus_entry($_POST['title'], $_POST['type'], 'publish', $metas);
            if ($_id) {
                echo json_encode(['id' => $_id, 'redirect_url' => get_permalink($_id)]);
                wp_die();
            }
        } else {
            echo json_encode(['error' => 'Usuário não habilitado para criar nova resposta']);
        }

        return false;
    }

    function ajax_callback_lock_form() {
        if (current_user_can('acolhesus_cgpnh')) {
            $key = 'acolhesus_' . sanitize_text_field($_POST['type']);
            update_option($key, 'locked');
        } else {
            echo json_encode(['error' => 'Usuário não habilitado para fechar a edição de usuários']);
        }
    }

    function toggle_lock_form_entries() {
        $_id = sanitize_text_field($_POST['form_id']);
        $toggle = $this->is_entry_locked($_id);
        if (update_post_meta($_id, "locked", !$toggle)) {
            $estado = (!$toggle) ? "fechado" : "aberto";
            echo json_encode([
                'success' => "Formulário $estado para edição!",
                'list' => $this->get_entry_strings($_id)
            ]);
        }

        wp_die();
    }

    private function get_entry_strings($id) {
        $status = ['status' => 'Aberto', 'class' => 'open'];
        $button = ['text' => 'Fechar', 'class' => 'danger'];;

        if($this->is_entry_locked($id)) {
            $status['status'] = 'Fechado';
            $status['class'] = 'closed';

            $button['text'] = 'Abrir';
            $button['class'] = 'info';
        }

        return ['status' => $status, 'button' => $button];
    }

    function is_form_type_locked($form_type) {
        return (get_option('acolhesus_' . $form_type) === "locked");
    }

    function saved_entry($entryid, $new_entry, $form) {
        global $post;
        update_post_meta($post->ID, '_entry_id', $entryid);
    }

    function acolhesus_single_page($template) {

        if ($this->isAcolheSusPage()) {
            return plugin_dir_path( __FILE__ ) . "templates/single_acolhesus.php";
        }

        return $template;
    }

    function acolhesus_archive_page($template) {
        if ($this->isAcolheSusPage()) {
            return plugin_dir_path( __FILE__ ) . "templates/archive_acolhesus.php";
        }

        return $template;
    }

    function isAcolheSusPage() {
        global $post;
        return is_object($post) && isset($post->post_type) && array_key_exists($post->post_type, $this->forms);
    }

    function load_acolhesus_assets() {
        wp_enqueue_style( 'rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/css/acolhesus.css');

        $type = get_post_type();
        if ( $type && array_key_exists($type, $this->forms)  || !empty(get_query_var('acolhe_sus')) ) {

            if (is_single()) {
                wp_enqueue_script( 'rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/js/single.js');
            } else if ( is_archive() || !empty(get_query_var('acolhe_sus')) ) {
                wp_enqueue_script( 'rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/js/archive.js');
            }
            wp_localize_script('rhs-acolhesus', 'acolhesus', [
                'ajax_url' => admin_url('admin-ajax.php')
            ]);
        }

    }

    function didnt_do_yet($action_name) {
        $list = get_option('acolhesus_done');

        if (empty($list) || !is_array($list)) {
            $list = [];
        }

        if ( in_array($action_name, $list) ) {
            return false;
        }

        $list[] = $action_name;

        update_option('acolhesus_done', $list);

        return true;

    }

    function rewrite_rules( &$wp_rewrite ) {
        
        $new_rules = array(
            'formularios-acolhesus' . "/?$" => "index.php?acolhe_sus=formularios",
        );

        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }

    function rewrite_rules_query_vars( $public_query_vars ) {

        $public_query_vars[] = "acolhe_sus";
        return $public_query_vars;

    }

    function rewrite_rule_template_include( $template ) {
        global $wp_query;

        if ($wp_query->get('acolhe_sus')) {

            if ( file_exists( plugin_dir_path( __FILE__ ) . '/templates/' . $wp_query->get( 'acolhe_sus' ) . '.php' ) ) {
                return plugin_dir_path( __FILE__ ) . '/templates/' . $wp_query->get( 'acolhe_sus' ) . '.php';
            }

        }

        return $template;
    }

    function can_user_view_form() {
        if ($this->isAcolheSusPage()) {
            if (current_user_can('view_acolhesus')) {
                if (is_single()) {
                    return $this->can_user_see(get_post_type());
                }
                return true;
            } else {
                wp_redirect(home_url());
            }
        }
        return false;
    }

    private function get_form_names() {
        return array_keys($this->forms);
    }

    public function can_add_entry($post_type) {
        $_form_keys = $this->get_form_names();
        if (in_array($post_type, $_form_keys)) {
            return ! $this->forms[$post_type]['uma_entrada_por_campo'];
        }
        return false;
    }

    public function can_user_see($post_type) {
        $_see_perm = "ver_".$post_type;

        return in_array($_see_perm, $this->get_user_forms_perms());
    }

    public function can_user_edit($post_type) {
        $_edit_perm = "editar_".$post_type;

        return in_array($_edit_perm, $this->get_user_forms_perms());
    }

    function return_all_user_entries($query) {
        if (!is_admin()) {
            if ( isset($query->query['post_type']) && array_key_exists($query->query['post_type'], $this->forms) ) {

                $camposDoUsuario = $this->get_user_campos();
				
				$meta_query = [];
				
				if (isset($_GET['campo']) && !empty($_GET['campo'])) {
					$meta_query[] = [
						'key' => 'acolhesus_campo',
						'value' => $_GET['campo'],
					];
				} else {
					$meta_query[] = [
						'key' => 'acolhesus_campo',
						'value' => $camposDoUsuario,
						'compare' => 'IN'
					];
				}
				
				if (isset($_GET['eixo']) && !empty($_GET['eixo'])) {
					$meta_query[] = [
						'key' => 'acolhesus_eixo',
						'value' => $_GET['eixo'],
					];
				}
				
				if (isset($_GET['fase']) && !empty($_GET['fase'])) {
					$meta_query[] = [
						'key' => 'acolhesus_fase',
						'value' => $_GET['fase'],
					];
				}
				
				if (isset($_GET['usuario']) && !empty($_GET['usuario'])) {
					$query->set( 'author', $_GET['usuario'] );
				}
				
                $query->set( 'posts_per_page', -1 );

                $query->set('meta_query', $meta_query);

                return;
            }
        }
    }

    public function get_user_campos($userID = 0) {
        if ($userID === 0)
            $userID = get_current_user_id();

        return get_user_meta($userID, 'acolhesus_campos');
    }

    public function get_user_forms_perms($userID = null) {
        if (is_null($userID))
            $userID = get_current_user_id();

        return get_user_meta($userID, 'acolhesus_form_perms');
    }

    public function get_logo_URL() {
        return ACOLHESUS_URL . 'assets/images/logo-full.png';
    }

    public function get_title() {
        return 'Plataforma de Gestão AcolheSUS';
    }

    public function render_logo() {
        $src = $this->get_logo_URL();
        $alt = $title = "Logo " . $this->get_title();

        echo "<img src='$src' alt='$alt' title='$title'/>";
    }

    public function render_entry_action($entry_id, $title) {
        $_attrs = ["class" => "danger", "title" => $title, "status" => "Fechar"];

        if ($this->is_entry_locked($entry_id)):
            $_attrs['class'] = "info";
            $_attrs['status'] = "Abrir";
        endif;

        $_html  = "<a id='entry-$entry_id' class='toggle_lock_form_entries entry-status btn btn-default btn-" . $_attrs['class'] . "'";
        $_html .= "data-status='". $_attrs['status'] ."'  data-id='" . $entry_id . "' data-txt='" . $title . "' href='#'>";
        $_html .= $_attrs['status'] . " edição </a>" ;

        echo $_html;
    }

    public function render_entry_status($entry_id) {
        $class = "open";
        $status = "Aberto";
        if ($this->is_entry_locked($entry_id)) {
            $class = "closed";
            $status = "Fechado";
        }

        echo "<div class='status-$entry_id'><span class='$class'> $status </span></div>";
    }

} // class

global $AcolheSUS;
$AcolheSUS = new AcolheSUS();

include('admin-forms.php');
