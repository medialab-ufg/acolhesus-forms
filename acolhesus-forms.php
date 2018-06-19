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

    public $campos_completos = [
        'AC' => 'AC - Rio Branco - Hospital de Urgência e Emergência',
        'AL' => 'AL - Arapiraca - Hospital de Emergência Dr. Daniel Houly',
        'AM' => 'AM - Manaus - Hospital Dr. João Lúcio Pereira Machado',
        'AP' => 'AP - Macapá - Hospital Dr. Oswaldo Cruz',
        'BA' => 'BA - Salvador - Hospital Geral do Estado',
        'CE' => 'CE - Fortaleza - Hospital São José',
        'DF' => 'DF - Brasília - Regional Macro Centro-Norte - APS',
        'ES' => 'ES',
        'GO' => 'GO - Cristalina - Hospital Municipal de Cristalina Chaud Salles',
        'MA' => 'MA - São Luís - UPA Itaqui Bacana',
        'MG' => 'MG - Juiz de Fora - Hospital Regional Dr. João Penido',
        'MS' => 'MS - Campo Grande - Hospital Regional de Mato Grosso do Sul',
        'MT' => 'MT - Várzea Grande - Hospital e Pronto Socorre Municipal de Várzea Grande',
        'PA' => 'PA - Belém - CAPS Renascer',
        'PB' => 'PB - João Pessoa - Maternidade Frei Damião',
        'PE' => 'PE',
        'PI' => 'PI - Parnaíba - Hospital Estadual Dirceu Arcoverde',
        'PR' => 'PR',
        'RJ' => 'RJ - Duque de Caxias - Hospital Estadual Adão Pereira Nunes',
        'RN' => 'RN - Natal - Hospital José Pedro Bezerra',
        'RO' => 'RO',
        'RR' => 'RR - Boa Vista - Pronto Atendimento Airton Rocha',
        'RS' => 'RS',
        'SC' => 'SC - São José - Hospital Regional de São José Dr. Homero Miranda',
        'SE' => 'SE',
        'SP' => 'SP',
        'TO' => 'TO - Palmas - Hospital Geral de Palmas'
    ];

    public $fases = [
        'fase_1' => 'Fase | - Análise Situacional',
        'fase_2' => 'Fase || - Elaboração e Modelização do Plano de Trabalho',
        'fase_3' => 'Fase ||| - Implementação, Monitoramento e Avaliação',
        'macrogestao' => 'Macrogestão'
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
                'name' => 'Matrizes de Cenário',
                'singular_name' => 'Matriz de Cenários'
            ],
            'form_id' => '', // Setado via admin
            'slug' => 'matriz_cenario',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => 0
        ],
        'indicadores' => [
            'labels' => [
                'name' => 'Indicadores Epidemiológicos',
                'singular_name' => 'Monitoramento de Indicadores Epidemiológicos'
            ],
            'slug' => 'indicadores',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => 0
        ],
        'visita_guiada' => [
            'labels' => [
                'name' => 'Roteiros de Visita Guiada',
                'singular_name' => 'Roteiro de Visita Guiada'
            ],
            'slug' => 'visita_guiada',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => false
        ],
        'fluxograma' => [
            'labels' => [
                'name' => 'Fluxogramas Analisadores',
                'singular_name' => 'Fluxograma Analisador'
            ],
            'slug' => 'fluxograma',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => false
        ],
        'matriz_p_criticos' => [
            'labels' => [
                'name' => 'Matrizes de Pontos Críticos',
                'singular_name' => 'Matriz de Pontos Críticos'
            ],
            'slug' => 'matriz_p_criticos',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => 0
        ],
        'matriz_objetivos' => [
            'labels' => [
                'name' => 'Matrizes de Objetivos e Atividades',
                'singular_name' => 'Matriz de Objetivos e Atividades'
            ],
            'slug' => 'matriz_objetivos',
            'uma_entrada_por_campo' => true,
            'fase' => 0,
            'eixo' => 0
        ],
        'avaliacao_grupos' => [
            'labels' => [
                'name' => 'Avaliações de Grupos',
                'singular_name' => 'Avaliação da Atuação de Grupo do Projeto'
            ],
            'slug' => 'avaliacao_grupos',
            'uma_entrada_por_campo' => false,
            'fase' => 0,
            'eixo' => false,
            'possui_validacao' => false
        ],
        'avaliacao_oficina' => [
            'labels' => [
                'name' => 'Avaliações de Oficinas Locais',
                'singular_name' => 'Avaliação de Oficina Local'
            ],
            'slug' => 'avaliacao_oficina',
            'uma_entrada_por_campo' => false,
            'fase' => 0,
            'eixo' => false,
            'possui_validacao' => false,
        ],
        'relatorio_oficina' => [
            'labels' => [
                'name' => 'Relatórios de Oficinas',
                'singular_name' => 'Relatório de Oficina'
            ],
            'slug' => 'relatorio_oficina',
            'uma_entrada_por_campo' => false,
            'fase' => 0,
            'eixo' => false,
            'omitir_macrogestao' => true,
        ],
        'memoria_reuniao' => [
            'labels' => [
                'name' => 'Memória de Reuniões',
                'singular_name' => 'Memória de Reunião/Vídeo'
            ],
            'slug' => 'memoria_reuniao',
            'uma_entrada_por_campo' => false,
            'fase' => 0,
            'eixo' => false,
        ],
    ];

    const CAMPO_META = 'acolhesus_campo';
    
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

        add_action('wp_ajax_add_entry_city', array(&$this, 'add_entry_city'));

        add_action('wp_ajax_remove_entry_city', array(&$this, 'remove_entry_city'));

        add_action('pre_get_posts', array(&$this, 'return_all_user_entries'));
    }

    private function set_forms_phases() {
        $this->forms['matriz_cenario']['fase'] = $this->fases[0];
        $this->forms['matriz_cenario']['eixo'] = $this->eixos[0];
        $this->forms['avaliacao_grupos']['fase'] = $this->fases[0];
        $this->forms['avaliacao_grupos']['eixo'] = $this->eixos[0];
        $this->forms['relatorio_oficina']['fase'] = $this->fases[0];
        $this->forms['relatorio_oficina']['eixo'] = $this->eixos[0];
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
                            'acolhesus_campo'=> $uf,
                            'acolhesus_eixo' => $form['eixo'],
                            'acolhesus_fase' => $form['fase']
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
                ],
                'show_ui' => false,
            ));

        }

    }

    function limit_paragraphs_input($attrs) {
        $attrs[ 'maxlength' ] = 500;
        return $attrs;
    }

    private function limit_paragraphs($formType) {
        $limit_paragraph = ["avaliacao_grupos", "avaliacao_oficina"];
        if (in_array($formType, $limit_paragraph)) {
            add_filter('caldera_forms_field_attributes-paragraph', array(&$this, 'limit_paragraphs_input'));
        }
    }

    function filter_the_content($content) {
        global $post;
        $formType = get_post_type();
        $_post_id = $post->ID;

        if (is_single() && $this->isAcolheSusPage()) {

            if (!$this->user_can_view($formType, get_the_title()))
                return;

            $form = "<br>";

            $this->lock_form($_post_id, $formType);
            $this->limit_paragraphs($formType);

            $form .= $this->render_fixed_meta($_post_id, $formType);

            $this->render_form_cities($_post_id, $formType);
            $form .= $this->get_entry_form($_post_id, $formType);

            return $content . $form;
        }

        return $content;
    }

    private function render_fixed_meta($_post_id, $formType) {
        $extra_info = "";
        if (isset($this->forms[$formType]) && (true !== $this->forms[$formType]['uma_entrada_por_campo']) ) {
            // Variável que caldera forms envia após submit do form
            if (!isset($_GET['cf_su'])) {
                $is_locked = $this->is_entry_locked($_post_id);
                $extra_info = "<div class='col-md-12 fixed-meta'>" . $this->get_basic_info_form($is_locked) . "</div>";
            }
        }

        if ("matriz_cenario" === $formType) {
            $municipios = json_encode(get_post_meta($_post_id, 'acolhesus_form_municipio'), JSON_UNESCAPED_UNICODE);
            echo "<input type='hidden' id='entry_cities' name='entry_cities' value='$municipios'>";
        }

        return $extra_info;
    }

    public function has_validations($formType) {
        if (isset($this->forms[$formType]['possui_validacao']))
            return $this->forms[$formType]['possui_validacao'];

        return true;
    }

    private function user_can_view($formType, $title) {
        $is_allowed = $this->can_user_see($formType);
        if (!$is_allowed)
            echo "<div class='user-cant-see'> Sem permissão para ver as respostas de $title </div>";

        return $is_allowed;
    }

    private function get_entry_form($_post_id, $formType) {
        $_form = "";
        if (array_key_exists($formType, $this->forms)) {
            $caldera_plugin = get_class_methods(Caldera_Forms::class);

            if (is_array($caldera_plugin) && in_array("render_form", $caldera_plugin)) {
                $saved_form_id = get_post_meta($_post_id, '_entry_id', true);
                $entry_id = ($saved_form_id) ? $saved_form_id : null;
                $_form .= Caldera_Forms::render_form(['id' => $this->forms[$formType]['form_id']], $entry_id);
            }
        }

        return $_form;
    }

    private function render_form_cities($id, $type='') {
        if ("matriz_cenario" === $type) {
            $uf = get_post_meta($id, self::CAMPO_META, true);
            $uf_cities = UFMunicipio::get_cities_options($uf);
            echo "<div class='col-md-6' id='form_id' data-id='$id'><label for='municipios-matriz-cenario'>  Municípios de abrangência da unidade </label> <br>";
            echo "<select multiple name='municipios-matriz-cenario' class='matriz-cenario-cities form-controle'> $uf_cities </select></div>";
        }
    }

    private function is_entry_locked($entry_id) {
        return get_post_meta($entry_id, "locked", true);
    }

    private function lock_form($form_id, $post_type) {
        if ($this->is_entry_locked($form_id) || !$this->can_user_edit($post_type) ) {
            add_filter('caldera_forms_field_attributes', array(&$this, 'set_acolhesus_readonly'), 20, 3);
            add_filter('caldera_forms_render_form_wrapper_classes', array(&$this, 'acolhesus_readonly_classes'), 20);
            add_filter('caldera_forms_render_get_field', array(&$this, 'acolhesus_readonly_field'));
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

    function acolhesus_readonly_field($field) {
        if ('filtered_select2' === $field['type']) {
            $field['config']['custom_class'] .= 'acolhesus_readonly_s2';
        } else if ('toggle_switch' == $field['type']) {
            $_field_val = $field['config']['default'];
            $answer = Caldera_Forms_Field_Util::find_select_field_value( $field, $_field_val );

            if (is_null($answer))
                return;

            $field['config']['default_option'] = $answer;
            $field['config']['selected_class'] = 'acolhesus_readonly';
            foreach ($field['config']['option'] as $_opt_id => $_opt_val ) {
                if ($_opt_val['calc_value'] != $field['config']['default_option']) {
                    unset( $field['config']['option'][$_opt_id] );
                }
            }
        }

        return $field;
    }

    function add_entry_city() {
        $r = [];

        if (isset($_POST['post_id']) && isset($_POST['city'])) {
            $r = add_post_meta($_POST['post_id'], 'acolhesus_form_municipio', $_POST['city']);
        }

        return json_encode($r);
    }

    function remove_entry_city() {
        if (isset($_POST['post_id']) && isset($_POST['city'])) {
            delete_post_meta($_POST['post_id'], 'acolhesus_form_municipio', $_POST['city']);
        }
    }
	
	function get_campos_do_usuario_as_options($selected = '') {
		$camposDoUsuario = $this->get_user_campos();
		$options = '';
		foreach ($camposDoUsuario as $campo) {
            $campo_completo = $this->campos_completos[$campo];

            $options .= "<option value='$campo'";
            $options .= selected($selected, $campo, false);
            $options .= "> $campo_completo </option>\n";
        }
		return $options;
	}
	
	function get_eixos_as_options($selected = '') {
        $options = "<option value=''></option>";
		foreach ($this->eixos as $eixo) {
            $options .= "<option value='$eixo'";
            $options .= selected($selected, $eixo, false);
            $options .= ">$eixo</option>\n";
        }
		return $options;
	}
	function get_fases_as_options($selected = '') {
		if (is_single()) {
            $options = "<option value=''></option>";

            $type = get_post_type();
            if (isset($this->forms[$type]['omitir_macrogestao']) && $this->forms[$type]['omitir_macrogestao']) {
                array_pop($this->fases);
            }
        }

		foreach ($this->fases as $slug => $fase) {
            $options .= "<option value='$slug'";
            $options .= selected($selected, $slug, false);
            $options .= "> $fase </option>\n";
        }
		return $options;
	}
	
    private function get_basic_info_form($is_locked = false) {
        global $post;
        
        $attr  = ($is_locked) ? "disabled='disabled'": '';
        $attr .= " required";
        $type = get_post_type();

        $campoAtual = get_post_meta($post->ID, self::CAMPO_META, true);
        $faseAtual = get_post_meta($post->ID, 'acolhesus_fase', true);
        $eixoAtual = get_post_meta($post->ID, 'acolhesus_eixo', true);

        $options = $this->get_campos_do_usuario_as_options($campoAtual);
        $camposHtml = $this->get_fixed_select("Campo de atuação", "acolhesus_campo", $attr, $post->ID, $options);

		$options = $this->get_fases_as_options($faseAtual);
        $faseHtml = $this->get_fixed_select("Fase", "acolhesus_fase", $attr, $post->ID, $options);


        if ($this->form_type_has_axis($type)) {
            $options = $this->get_eixos_as_options($eixoAtual);
            $eixoHtml = $this->get_fixed_select("Eixo", "acolhesus_eixo", $attr, $post->ID, $options);
        } else {
            $eixoHtml = "";
        }

		return $camposHtml . $faseHtml . $eixoHtml;
    }

    private function get_fixed_select($title, $name, $attr, $post_id, $options=[]) {
        $id = $name . "_selector";
        $html  = "<div class='col-md-4 $name'> $title <span class='field_required'>*</span>";
        $html .= "<select id='$id' $attr class='acolhesus_basic_info_selector' name='$name' data-post_id='$post_id'>";
        $html .= $options . " </select>";
        if (in_array($name, ["acolhesus_eixo","acolhesus_fase"]))
            $html .= $this->required_field();
        $html .= "</div>";

        return $html;
    }

    private function required_field() {
        return "<div class='fixed field_required'> Campo obrigatório!</div>";
    }

    function ajax_callback_save_post_basic_info() {
        $_all_required_fields = isset($_POST['acolhesus_campo']) && !empty($_POST['acolhesus_fase']) && !empty($_POST['acolhesus_eixo']);
        if (isset($_POST['acolhesus_campo']) && $_POST['post_id']) {
            update_post_meta($_POST['post_id'], self::CAMPO_META, $_POST['acolhesus_campo']);
            update_post_meta($_POST['post_id'], 'acolhesus_fase', $_POST['acolhesus_fase']);
            update_post_meta($_POST['post_id'], 'acolhesus_eixo', $_POST['acolhesus_eixo']);
        } else{
            echo json_encode(['error' => 'Campos obrigatórios não enviados!']);
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
            do_action('acolhesus_lock_form', $key);
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
            do_action('acolhesus_toggle_lock_entry', $_id, !$toggle);
        }

        wp_die();
    }

    private function get_entry_strings($id) {
        $status = ['status' => 'Aberto', 'class' => 'open'];
        $button = ['text' => 'Validar formulário', 'class' => 'danger'];;

        if($this->is_entry_locked($id)) {
            $status['status'] = 'Fechado';
            $status['class'] = 'closed';

            $button['text'] = 'Abrir edição';
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
                wp_enqueue_script('jquery-ui-accordion', null, array('jquery'), null, false);
                wp_enqueue_script('rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/js/single.js', array('jquery', 'jquery-ui-accordion'));

                if ("matriz_cenario" === $type) {
                    wp_enqueue_style('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.css');
                    wp_enqueue_script('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.js', array('jquery'));
                }

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
						'key' => self::CAMPO_META,
						'value' => $_GET['campo'],
					];
				} else {
					$meta_query[] = [
						'key' => self::CAMPO_META,
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
        $strings = $this->get_entry_strings($entry_id);
        $_attrs = [
            "class" => $strings['button']['class'],
            "title" => $title,
            "status" => $strings['button']['text']
        ];        

        $_html  = "<a id='entry-$entry_id' class='toggle_lock_form_entries entry-status btn btn-default btn-" . $_attrs['class'] . "'";
        $_html .= "data-status='". $_attrs['status'] ."'  data-id='" . $entry_id . "' data-txt='" . $title . "' href='#'>";
        $_html .= $_attrs['status'] . "</a>" ;

        echo $_html;
    }

    public function render_entry_status($entry_id) {
        $strings = $this->get_entry_strings($entry_id);
        $class = $strings['status']['class'];
        $status = $strings['status']['status'];

        echo "<div class='status-$entry_id'><span class='$class'> $status </span></div>";
    }

    public function get_entry_phase($id) {
        $fase_slug = get_post_meta($id, 'acolhesus_fase', true);
        $fase = empty($fase_slug) ? "----" : $this->fases[$fase_slug];

        return $fase;
    }

    public function get_entry_axis($id) {
        return get_post_meta($id, 'acolhesus_eixo', true);
    }

    public function form_type_has_axis($type) {
        return (isset($this->forms[$type]) && $this->forms[$type]['eixo']);
    }

} // class

global $AcolheSUS;
$AcolheSUS = new AcolheSUS();

include('admin-forms.php');
include('logger.php');
