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

require_once "acolhesus-common.php";

class AcolheSUS {

    use AcolheSUSCommon;

    public $forms = [
        'matriz_cenario' => [
            'labels' => [
                'name' => 'Matriz de Cenário',
                'singular_name' => 'Matriz de Cenário'
            ],
            'form_id' => '', // Setado via admin
            'slug' => 'matriz_cenario',
            'uma_entrada_por_campo' => true,
            'fase' => ['fase_1'],
            'eixo' => 0
        ],
        'poster' => [
            'labels' => [
                'name' => 'Pôster Seminário AcolheSUS',
                'singular_name' => 'Pôster Seminário AcolheSUS'
            ],
            'slug' => 'poster',
            'uma_entrada_por_campo' => true,
            'fase' => [],
            'eixo' => 0,
			'diligencias' => 'Curadoria'
        ],
        'ind_materno_infantil' => [
            'labels' => [
                'name' => 'Indicadores Materno-Infantil',
                'singular_name' => 'Indicadores Materno-Infantil'
            ],
            'slug' => 'ind_materno_infantil',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1'],
            'eixo' => 0,
            'omitir_macrogestao' => true
        ],
        'indicadores_caps' => [
            'labels' => [
                'name' => 'Indicadores CAPS',
                'singular_name' => 'Indicadores CAPS'
            ],
            'slug' => 'indicadores_caps',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1'],
            'eixo' => 0,
            'omitir_macrogestao' => true
        ],
        'indicadores' => [
            'labels' => [
                'name' => 'Indicadores Hospital Geral',
                'singular_name' => 'Indicadores Hospital Geral'
            ],
            'slug' => 'indicadores',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1'],
            'eixo' => 0,
            'omitir_macrogestao' => true
        ],
        'indicadores_basica' => [
            'labels' => [
                'name' => 'Indicadores da Atenção Básica',
                'singular_name' => 'Indicadores da Atenção Básica'
            ],
            'slug' => 'indicadores_basica',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1'],
            'eixo' => 0,
            'omitir_macrogestao' => true
        ],
        'visita_guiada' => [
            'labels' => [
                'name' => 'Roteiro de Visita Guiada',
                'singular_name' => 'Roteiro de Visita Guiada'
            ],
            'slug' => 'visita_guiada',
            'uma_entrada_por_campo' => true,
            'fase' => ['fase_1'],
            'eixo' => false,
            'can_not_save_incomplete' => true
        ],
        'fluxograma' => [
            'labels' => [
                'name' => 'Fluxograma Analisador',
                'singular_name' => 'Fluxograma Analisador'
            ],
            'slug' => 'fluxograma',
            'uma_entrada_por_campo' => true,
            'fase' => ['fase_1'],
            'eixo' => false,
            'can_not_save_incomplete' => true
        ],
        'matriz_p_criticos' => [
            'labels' => [
                'name' => 'Matriz de Pontos Críticos',
                'singular_name' => 'Matriz de Pontos Críticos'
            ],
            'slug' => 'matriz_p_criticos',
            'uma_entrada_por_campo' => true,
            'fase' => ['fase_1'],
            'eixo' => 'todos'
        ],
        'plano_trabalho' => [
            'labels' => [
                'name' => 'Plano de Trabalho',
                'singular_name' => 'Plano de Trabalho'
            ],
            'slug' => 'plano_trabalho',
            'uma_entrada_por_campo' => true,
            'fase' => ['fase_2'],
            'eixo' => 'todos'
        ],
        'avaliacao_grupos' => [
            'labels' => [
                'name' => 'Avaliação de Grupo',
                'singular_name' => 'Avaliação de Grupo'
            ],
            'slug' => 'avaliacao_grupos',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1', 'fase_2', 'fase_3', 'macrogestao'],
            'eixo' => false,
            'possui_validacao' => false,
            'omitir_macrogestao' => true
        ],
        'avaliacao_oficina' => [
            'labels' => [
                'name' => 'Avaliação de Oficina Local',
                'singular_name' => 'Avaliação de Oficina Local'
            ],
            'slug' => 'avaliacao_oficina',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1', 'fase_2', 'fase_3', 'macrogestao'],
            'eixo' => false,
            'possui_validacao' => false,
            'omitir_macrogestao' => true
        ],
        'relatorio_oficina' => [
            'labels' => [
                'name' => 'Relatório de Oficina',
                'singular_name' => 'Relatório de Oficina'
            ],
            'slug' => 'relatorio_oficina',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1', 'fase_2', 'fase_3', 'macrogestao'],
            'eixo' => false,
            'possui_validacao' => false,
            'omitir_macrogestao' => true
        ],
        'memoria_reuniao' => [
            'labels' => [
                'name' => 'Videoconferências/Reunião da Gestão ou da Coordenação',
                'singular_name' => 'Videoconferências/Reunião da Gestão ou da Coordenação',
                'alias' => 'Videoconferências'
            ],
            'slug' => 'memoria_reuniao',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1', 'fase_2', 'fase_3', 'macrogestao'],
            'eixo' => false,
            'possui_validacao' => false,
            'omitir_macrogestao' => true
        ],
        'atividades_dispersao' => [
            'labels' => [
                'name' => 'Memória de Reunião/Atividades de Dispersão',
                'singular_name' => 'Memória de Reunião/Atividades de Dispersão',
                'alias' => 'Memória de Reunião'
            ],
            'slug' => 'atividades_dispersao',
            'uma_entrada_por_campo' => false,
            'fase' => ['fase_1', 'fase_2', 'fase_3', 'macrogestao'],
            'eixo' => false,
            'possui_validacao' => false,
            'omitir_macrogestao' => true
        ],
    ];

    private $caldera_forms;
    private $caldera_entries;

    const CAMPO_META = 'acolhesus_campo';
    const CGPNH = 'acolhesus_cgpnh'; // 'maiores' permissoes
    const RESPONDENT = 'view_acolhesus'; // 'maiores' permissoes
    const ANSWER_ID = '_cf_cr_pst';

    function __construct() {
        global $wpdb;
        $this->caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
        $this->caldera_forms = $wpdb->prefix . 'cf_forms';

        add_action('init', [&$this, 'register_post_types']);

        add_action('init', [&$this, 'init_default_data']);

        add_action('init', [&$this, 'acolhesus_rewrite_reports']);

        add_filter('the_content', [&$this, 'filter_the_content']);

        add_action('caldera_forms_entry_saved', [&$this, 'saved_entry'], 10, 3);

        add_action('wp_enqueue_scripts', [&$this, 'load_acolhesus_assets']);

        add_filter('archive_template', [&$this, 'acolhesus_archive_page']);

        add_filter('single_template', [&$this, 'acolhesus_single_page']);

        add_action('generate_rewrite_rules', array( &$this, 'rewrite_rules' ), 10, 1 );

        add_filter('query_vars', array( &$this, 'rewrite_rules_query_vars' ) );

        add_filter('template_include', array( &$this, 'rewrite_rule_template_include' ));

        add_action('template_redirect', array(&$this, 'can_user_view_form'));

        add_action('wp_ajax_acolhesus_save_post_basic_info', array(&$this, 'ajax_callback_save_post_basic_info'));

        add_action('wp_ajax_acolhesus_add_form_entry', array(&$this, 'ajax_callback_add_form_entry'));

        add_action('wp_ajax_acolhesus_lock_form', array(&$this, 'ajax_callback_lock_form'));

        add_action('wp_ajax_toggle_lock_single_form', array(&$this, 'toggle_lock_form_entries'));

        add_action('wp_ajax_unlock_single_form', array(&$this, 'unlock_form_entries'));

        add_action('wp_ajax_add_entry_city', array(&$this, 'add_entry_city'));

        add_action('wp_ajax_remove_entry_city', array(&$this, 'remove_entry_city'));

        add_action('wp_ajax_remove_form_entry', array(&$this, 'remove_form_entry'));

        add_action('wp_ajax_delete_new_form_tag', array(&$this, 'delete_new_form_tag'));

        add_action('wp_ajax_delete_form_attachment', array(&$this, 'delete_form_attachment'));

        add_action('pre_get_posts', array(&$this, 'return_all_user_entries'));

        add_filter('acolhesus_add_entry_btn', array(&$this, 'acolhesus_add_entry_btn_callback'));

        add_action('wp_ajax_acolhesus_save_for_later', array(&$this, 'ajax_callback_save_for_later'));

        add_action('caldera_forms_submit_post_process', array(&$this, 'get_old_attachment'), 10, 4 );

        add_action('caldera_forms_submit_post_process', array(&$this, 'confirm_save'), 10, 4 );

        add_filter('caldera_forms_ajax_return', array(&$this, 'filter_caldera_forms_ajax_return'), 10, 2 );

        add_action('wp_ajax_acolhesus_verify_indicadores_info', array(&$this, 'ajax_callback_verify_indicadores_info'));

        add_action("wp_ajax_acolhesus_reports_chart", array(&$this, "ajax_callback_reports_charts"));

        add_action("wp_ajax_acolhesus_report_one", array(&$this, "ajax_callback_report_one"));

        add_filter('restrict_manage_users', array(&$this, 'filter_users_cgpnh'));

        //add_filter('caldera_forms_mailer', array(&$this, 'append_content_to_mail'), 10, 3);

        add_filter( 'comment_moderation_recipients', array(&$this, 'send_email'), 11, 2 );

        add_filter( 'comment_notification_recipients', array(&$this, 'send_email'), 11, 2 );

        add_filter('comment_moderation_text', array(&$this, 'email_message'), 11, 2);

        add_filter('comment_notification_text', array(&$this, 'email_message'), 11, 2);
    }

    function send_email($emails, $comment_id)
    {
        if(isset($_POST['comment_post_ID']))
        {
            $id = sanitize_text_field($_POST['comment_post_ID']);
            $emails_list = $this->get_forward_mail($id);

            foreach($emails_list as $email)
            {
                $emails[] = $email;
            }
        }

        return $emails;
    }

    function email_message($notify_message, $comment_id){
        $post = get_post($_POST['comment_post_ID']);
        $post_title = $post->post_title;
        $comment = get_comment($comment_id);
        $author_name = $comment->comment_author;
        $form_link = get_permalink($_POST['comment_post_ID']);
        ob_start();
        ?>
        <h3>Novo comentário</h3>
        <p>
            O usuário <?php echo $author_name;?> comentou <strong><?php echo $_POST['comment']?></strong> na postagem <a href="<?php echo $form_link;?>"> "<?php echo $post_title; ?>"</a>.
        </p>
        <?php
        $notify_message = ob_get_clean();

        return $notify_message;
    }

    private function get_forward_mail($form_id)
    {
        global $wpdb;
        if (is_null($form_id)) {
            $form_id = $_POST[self::ANSWER_ID];
        }

        $_entry_id = get_post_meta($form_id, '_entry_id', true);
        $sql = "SELECT post.meta_value as estado from $wpdb->postmeta post JOIN $wpdb->postmeta postmeta 
                ON post.post_id = postmeta.post_id 
                where 
                    (post.meta_key='acolhesus_campo' and postmeta.meta_key='_entry_id') 
                        AND 
                    postmeta.meta_value = '$_entry_id'";

        $results = $wpdb->get_results($sql);
        $email = [];

        if(!empty($results))
        {
            $estado = $results[0]->estado;

            $sql = "SELECT * FROM $wpdb->posts WHERE post_type='poster' and ID=$form_id;";
            $poster = $wpdb->get_results($sql);

            if(!empty($poster)) {
                $email = $this->get_forward_mail_by_state($estado);
            }

            $ailana   = ['AL', 'MA', 'PI', 'RN'];
            $diego    = ['AL', 'AM', 'BA'];
            $danyelle = ['AC', 'TO', 'SC'];
            $julimar = ['MG'];

            if (in_array($estado, $ailana)) {
                $email[] = $this->get_email_by_responsible('ailana');
            } else if(in_array($estado, $diego)) {
                $email[] = $this->get_email_by_responsible('diego');
            } else if(in_array($estado, $danyelle)) {
                $email[] = $this->get_email_by_responsible('danyelle');
            } else if (in_array($estado,$julimar)) {
                $email[] = $this->get_email_by_responsible('julimar');
            }
        }

        return $email;
    }

    function get_email_by_responsible($name) {
        $state_responsibles = $this->get_responsibles();
        return (array_key_exists($name, $state_responsibles) ? $state_responsibles[$name] : '');
    }

    function get_responsibles() {
        return [
            'ailana'   => 'ailana.lira@saude.gov.br',
            'danyelle' => 'danyelle.cavalcante@saude.gov.br',
            'diego'    => 'diegop.santos@saude.gov.br',
            'flavia'   => 'flaviaborgesleite@gmail.com',
            'gilberto' => 'gilbertoscarazatti7@gmail.com',
            'julimar'  => 'julimar.barros@saude.gov.br',
            'ricardo'  => 'drricardovolpe@globo.com',
            'thania'   => 'thania.arruda@hotmail.com'
        ];
    }

    function get_forward_mail_by_state($state) {
        $email = [];
        switch ($state)
        {
            case 'AC':
                $email = [$this->get_email_by_responsible('gilberto')];
                break;
            case 'AL':
                $email = [$this->get_email_by_responsible('danyelle'), $this->get_email_by_responsible('ricardo')];
                break;
            case 'AM':
                $email = [$this->get_email_by_responsible('ailana'), $this->get_email_by_responsible('flavia')];
                break;
            case 'AP':
                $email = [$this->get_email_by_responsible('gilberto')];
                break;
            case 'BA':
                $email = [$this->get_email_by_responsible('julimar'), $this->get_email_by_responsible('ricardo')];
                break;
            case 'CE':
                $email = [$this->get_email_by_responsible('diego'), $this->get_email_by_responsible('flavia')];
                break;
            case 'DF':
                $email = [$this->get_email_by_responsible('thania'), $this->get_email_by_responsible('gilberto')];
                break;
            case 'MA':
                $email = [$this->get_email_by_responsible('ricardo')];
                break;
            case 'MG':
                $email = [$this->get_email_by_responsible('ailana'), $this->get_email_by_responsible('flavia')];
                break;
            case 'MS':
                $email = [$this->get_email_by_responsible('danyelle'), $this->get_email_by_responsible('gilberto')];
                break;
            case 'MT':
                $email = [$this->get_email_by_responsible('ricardo')];
                break;
            case 'PA':
                $email = [$this->get_email_by_responsible('diego'), $this->get_email_by_responsible('flavia')];
                break;
            case 'PB':
                $email = [$this->get_email_by_responsible('julimar'), $this->get_email_by_responsible('ricardo')];
                break;
            case 'PI':
                $email = [$this->get_email_by_responsible('thania'), $this->get_email_by_responsible('gilberto')];
                break;
            case 'SC':
                $email = [$this->get_email_by_responsible('flavia')];
                break;
            case 'RN':
                $email = [$this->get_email_by_responsible('gilberto')];
                break;
            case 'TO':
                $email = [$this->get_email_by_responsible('ricardo')];
                break;
        }

        return $email;
    }

    function filter_users_cgpnh(){
        global $pagenow;

        if (is_admin() && $pagenow == 'users.php') {
            print "<button style='margin: 1px 5px 0 5px' class='button'>
                    <a style='color: #555; text-decoration: none' href='users.php?role=acolhesus_cgpnh'> CGPNH </a>
                  </button>";

            print "<button style='margin-top: 1px' class='button'>
                    <a style='color: #555; text-decoration: none' href='users.php?role=view_acolhesus'> GEL/GEE </a>
                  </button>";
        }
    }

    /* Charts */
    function ajax_callback_reports_charts()
    {
        $formType = $_POST['form'];
        $post_id = sanitize_text_field($_POST['post_id']);
        $chart_type = $_POST['chart_type'];
        $phase = $_POST['phase'];
        $state = $_POST['field'];

        $result = [];
        $acholheSUSReports = new AcolheSUSReports();
        $fields = $acholheSUSReports->getFormFields($formType);

        $pie_bar = [
            'avaliacao_oficina',
            'avaliacao_grupos',
            'matriz_cenario'
        ];

        $line = [
            'ind_materno_infantil',
            'indicadores_caps',
            'indicadores',//Indicadores Hospital Geral
            'indicadores_basica'
        ];

        if(in_array($formType, $pie_bar))
        {
            $index = 'total'; $switch_index = '';

            foreach ($fields as $id => $campo) {
                $tipo = $campo["type"];
                if (in_array($tipo, $acholheSUSReports->report_fields))
                {
                    if (is_string($state) && (strlen($state) === 2) || is_string($phase))
                    {
                        $value = $acholheSUSReports->getFilterForCharts($state, $phase,$formType, $id);
                    }else
                    {
                        $value = intval($acholheSUSReports->getAnswerStats($id, false, $post_id));
                    }

                    $result[$index][$campo['label']] = $value;
                }else if ($tipo === "html" && !in_array($id, $acholheSUSReports->excluded_fields))
                {
                    $index = strip_tags($campo["config"]["default"]);
                    $switch_index = strip_tags($campo["config"]["default"])[0];
                }else if($tipo === "toggle_switch")
                {
                    $result[$switch_index][$campo['label']]['Sim'] = intval($acholheSUSReports->getTotal($id, $tipo,"Sim"));
                    $result[$switch_index][$campo['label']]['Não'] = intval($acholheSUSReports->getTotal($id, $tipo,"Não"));
                }
            }

            $this->get_percent($result, $formType, $chart_type);
        }
        else if(in_array($formType, $line))
        {
            global $wpdb;
            $sql = 'SELECT ID FROM '.$wpdb->posts.' where post_type="'.$formType.'" and post_status="publish"';
            $ids = $wpdb->get_results($sql, ARRAY_A);


            foreach ($ids as $id)
            {
                $id = $id['ID'];

                $sql = 'SELECT meta_value FROM '.$wpdb->postmeta . ' WHERE post_id='.$id.' AND meta_key = "acolhesus_campo"';
                $estado = $wpdb->get_results($sql, ARRAY_A);

                if(!empty($estado) && !empty($estado[0]['meta_value']))
                {
                    $result[$estado[0]['meta_value']][] = $this->get_specific_form_data($formType, $id, true);
                }
            }
        }

        echo json_encode($result);
        wp_die();
    }

    function get_percent(&$data, $formType, $chart_type)
    {
        if($formType === 'avaliacao_oficina' || $formType === 'avaliacao_grupos' || $formType = 'matriz_cenario' )
        {
            if ($formType === 'avaliacao_grupos') {
                $sum = $data['total'];
                $sum = current($sum);
                unset($data['total']);
            }

            foreach ($data as $piece_name => $piace)
            {
                if($formType === 'avaliacao_oficina')
                {
                    $sum = array_sum($piace);
                }

                foreach ($piace as $option_name => $option)
                {
                    $data[$piece_name][$option_name] = [];
                    if(!is_array($option))
                    {
                        $data[$piece_name][$option_name]['total'] = $option;
                    }

                    if($chart_type !== 'pie')
                    {
                        $data[$piece_name][$option_name]['percent'] = doubleval(sprintf("%.1f",(100 * $option) / $sum));
                    }
                    else{
                        if(!is_array($option))
                        {
                            $data[$piece_name][$option_name]['percent'] = doubleval($option);
                        }else {
                            $data[$piece_name][$option_name] = $option;/*YES or NOT*/
                        }
                    }
                }
            }
        }
    }

    /*Reports especifics*/
    function ajax_callback_report_one()
    {
        $formType = $_POST['form'];
        $post_id = sanitize_text_field($_POST['post_id']);

        $result = $this->get_specific_form_data($formType, $post_id);
        $html = $this->wrap_in_html($formType, $result, $post_id);

        echo json_encode($html);
        wp_die();
    }

    function get_specific_form_data($formType, $post_id, $keep_title = false)
    {
        $acholheSUSReports = new AcolheSUSReports(); $result = [];
        $fields = $acholheSUSReports->getFormFields($formType);

        $index = '';
        $types = [
            'toggle_switch',
            'text',
            'number',
            'date_picker',
            'dropdown',
            'paragraph',
            'checkbox',
            'radio'
        ];
        foreach ($fields as $field_id => $campo) {
            $tipo = $campo["type"];
            if ($tipo === "wysiwyg") {
                preg_match("/(Ponto Crítico )[0-9]+/", $campo['label'], $index);
                $index = $index[0];
                if(strpos($campo['label'], 'Ponto Crítico') === 0 && strlen($campo['label']) <= 16)
                {
                    $result[$index]['name'] = $acholheSUSReports->getAnswerToEspecific($field_id,$post_id);
                }else
                {
                    $data = ['title' => $campo['label'], 'value' => $acholheSUSReports->getAnswerToEspecific($field_id,$post_id)];
                    if(!empty($index))
                        $result[$index][] = $data;
                    else {
                        $index = key($result);
                        next($result);
                        $result[$index][] = $data;
                    }
                }
            }else if(in_array($tipo, $types))
            {
                if($tipo === 'toggle_switch' || $tipo === 'text' ||
                    $tipo === 'number' || $tipo === 'paragraph' || $tipo === 'checkbox' || $tipo === 'radio')
                {
                    $label = explode(' ', $campo['label'])[0];
                    if(strlen($label) == 1 || $keep_title)
                        $label = $campo['label'];
                }
                elseif ($tipo == 'date_picker' || $tipo == 'dropdown')
                {
                    $label = $campo['label'];
                }

                $data = ['title' => $label, 'value' => $acholheSUSReports->getAnswerToEspecific($field_id,$post_id)];
                $result[] = $data;
            }
        }

        return $result;
    }

    function wrap_in_html($form_type, $result, $post_id)
    {
        $html = '';
        switch ($form_type)
        {
            case 'matriz_p_criticos':
                foreach ($result as $ponto_critico_name => $ponto_critico_info)
                {
                    $html .= $this->wrap_matriz_pontos_criticos_in_html($ponto_critico_name, $ponto_critico_info);
                }
                break;
            case 'matriz_cenario':
                $new_result = [];
                foreach($result as $r)
                {
                    $new_result[$r['title']] = $r['value'];
                }
                $html = $this->wrap_matriz_cenario_html($new_result, $post_id);
                break;
            case 'relatorio_oficina':
            case 'memoria_reuniao': //Vídeo conferência
            case 'atividades_dispersao': //Memória de Reunião/Atividades de Dispersão
                $html = $this->wrap_relatorio_mem_atividades_html($result);
                break;
        }

        return $html;
    }

    public function wrap_matriz_cenario_html($data, $form_id) {
        if ($form_id) {
            $populacao = $this->getCityPopulation($form_id);
            $count_cities = $this->getCitiesCount($form_id);
        }

        $num_profissionais = 'C Quantos profissionais estão alocados no serviço';

        ob_start();

        include_once(dirname(__FILE__) . '/templates/reports/matriz_cenario.php');

        return ob_get_clean();
    }

    public function wrap_matriz_pontos_criticos_in_html($ponto_critico_name, $ponto_critico_info)
    {
        ob_start();
        ?>
        <div class="ponto-critico">
            <div class="box-info">
                <h3 class="text-center"><?php echo $ponto_critico_name?></h3>
                <div class="text-center box-details">
                    <?php
                    if(!empty($ponto_critico_info['name']))
                        echo $ponto_critico_info['name'];
                    else echo "<i>Nome não cadastrado</i>";
                    ?>
                </div>
            </div>

            <div class="box-info">
                <h3 class="text-center">Caracterização</h3>
                <div class="box-details">
                    <?php
                    $caracterizacao = $this->get_info_in_result($ponto_critico_info, "Caracterização do ".$ponto_critico_name)[0];
                    if(!empty($caracterizacao))
                        echo $caracterizacao;
                    else echo "<i>Caracterização não cadastrada</i>";
                    ?>
                </div>
            </div>

            <div class="box-info">
                <h3 class="text-center">Diretrizes/dispositivos</h3>
                <div class="box-details">
                    <?php
                    $diretrizes = $this->get_info_in_result($ponto_critico_info, "Diretrizes e/ou dispositivos PNH; ferramentas de gestão da clínica e/ou eixos do projeto")[0];
                    if (is_null($diretrizes) && isset($ponto_critico_info["value"])) {
                        $diretrizes = $ponto_critico_info["value"];
                    }

                    if (!empty($diretrizes))
                        echo $diretrizes;
                    else echo "<i>Diretrizes/dispositivos não cadastrados</i>";
                    ?>
                </div>
            </div>

            <div class="box-info">
                <h3 class="text-center">Causas</h3>
                <div class="box-details">
                    <?php
                    $cat = 0;
                    $result = $this->get_info_in_result($ponto_critico_info, "Causas do ".$ponto_critico_name);
                    foreach ($result as $cause): ?>
                    
                        <h3> <?php echo $this->categorias_pontos_criticos[$cat]; ?></h3>
                        <div class="cause"> <?php echo (empty($cause) ? "<p> ---- </p>" : $cause); ?> </div>

                    <?php $cat++; endforeach; ?>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    public function wrap_relatorio_mem_atividades_html($result)
    {
        ob_start();
        $start_date = array_shift($result)['value'];
        $start_date = date("d/m/Y", strtotime($start_date));
        $end_date = array_shift($result)['value'];
        $end_date = date("d/m/Y", strtotime($end_date));
        $_headers = "";

        if (isset($_POST["meta"])) {
         $_headers = AcolheSUSReports::getStatePhaseHeaders($_POST["meta"]);
        }
        ?>
        <div>
            <p> <?php echo $_headers ?> </p>
            <h4>Realização de <strong><?php echo $start_date; ?></strong> até <strong><?php echo $end_date;?></strong> no período da <strong><?php echo strtolower(array_shift($result)['value']);?></strong></h4><br>
            <?php
            foreach ($result as $r)
            {
                echo "<h3>".$r['title']."</h3>";
                echo "<p class='text-justify'>".$r['value']."</p><br>";
            }
            ?>
        </div>
        <?php

        return ob_get_clean();
    }

    function get_info_in_result($result, $needle)
    {
        $needle = strtolower($needle);
        foreach ($result as $information)
        {
            if(is_array($information))
            {
                if(strpos(strtolower($information['title']), $needle) !== false)
                {
                    $return[] = $information['value'];
                }
            }
        }

        return $return;
    }

    function ajax_callback_verify_indicadores_info(){
        global $wpdb;
        $month_id = $_POST['data']['month_id']; $year_id = $_POST['data']['year_id']; $state = $_POST['data']['state'];
        $month_val = $_POST['data']['month_val']; $year_val = $_POST['data']['year_val'];

        $sql = "
        SELECT mesano.*, state.estado from
            (SELECT entry_a.entry_id, entry_a.value mes, entry_b.value ano
                FROM ".$this->caldera_entries." as entry_a join ".$this->caldera_entries." as entry_b
                where entry_a.field_id='".$month_id."' AND entry_b.field_id='".$year_id."' AND entry_a.entry_id=entry_b.entry_id
            )
            as mesano
        JOIN
            (SELECT post.meta_value as estado, postmeta.meta_value as entry_id from $wpdb->postmeta post JOIN $wpdb->postmeta postmeta 
                ON post.post_id = postmeta.post_id 
                where 
                    (post.meta_key='acolhesus_campo' and postmeta.meta_key='_entry_id') 
                        AND
                    post.post_id IN 
                        (SELECT ID FROM $wpdb->posts where post_type='indicadores')
            ) 
            as state
        ON mesano.entry_id = state.entry_id
        ";

        $results = $wpdb->get_results($sql);

        foreach ($results as $result)
        {
            if($state == $result->estado && $month_val == $result->mes && $year_val == $result->ano)
            {
                echo "false";
                return;
            }
        }

        echo "true";
        return;

    }

    function confirm_save($form, $referrer, $process_id, $entry_id)
    {
        global $AcolheSUSLogger;
        $post_id = $AcolheSUSLogger->get_post_id_by_entry_id($entry_id);
        wp_publish_post($post_id);

        //Add as saved
        add_post_meta($post_id, "acolhe_sus_add_as_saved", true);
    }

    function get_old_attachment($form, $referrer, $process_id, $entry_id)
    {
        $to_save = [];
        foreach ($form['fields'] as $field)
        {
            if(strcmp($field['type'], 'advanced_file') === 0 )
            {
                $field_id = $field["ID"];
                $slug = $field['slug'];
                $anexos = $this->get_attachments($field_id);
                foreach ($anexos as $attachment)
                {
                    $to_save[] = $attachment;
                }
            }
        }

        if(!empty($to_save))
        {
            update_option('rhs_old_attachment', $to_save);
            update_option('rhs_temp_slug', $slug);

            global $wpdb;
            $sql_delete = "DELETE FROM " . $this->caldera_entries . " WHERE entry_id = '$entry_id' AND slug = '$slug'";

            $wpdb->query($sql_delete);
        }else{
            delete_option('rhs_old_attachment');
            delete_option('rhs_temp_slug');
        }
    }

    function filter_caldera_forms_ajax_return( $out, $form )
    {
        $old_attach = get_option('rhs_old_attachment');
        if(!empty($old_attach))
        {
            foreach ($form['fields'] as $field)
            {
                if(strcmp($field['type'], 'advanced_file') === 0 )
                {
                    $field_id = $field["ID"];
                    $form_id = get_the_ID();
                    if ($form_id) {
                        $entry = get_post_meta($form_id, '_entry_id', true);
                        if ($entry) {
                            global $wpdb;
                            $caldera_entries = $this->caldera_entries;
                            $slug = get_option('rhs_temp_slug');

                            if(!empty($slug))
                            {
                                foreach ($old_attach as $att)
                                {
                                    $att = $att['value'];
                                    $sql_insert = "INSERT INTO $caldera_entries (entry_id, field_id, slug, value) VALUES ('$entry', '$field_id', '$slug', '$att')";
                                    $wpdb->query($sql_insert);
                                }
                            }
                        }
                    }

                    delete_option('rhs_old_attachment');
                    delete_option('rhs_temp_slug');
                }
            }
        }

        return $out;
    }

    function ajax_callback_save_for_later()
    {
        global $wpdb, $AcolheSUSLogger;
        $post_id = sanitize_text_field($_POST[self::ANSWER_ID]);
        $_entry_id = get_post_meta($post_id, '_entry_id', true);
        if(!$_entry_id)
        {
            $new_entry = array(
                'form_id' => $_POST['formId'],
                'user_id' => get_current_user_id(),
                'datestamp' => date_i18n('Y-m-d H:i:s', time(), 0),
                'status' => 'pending'
            );

            $wpdb->insert($wpdb->prefix . 'cf_form_entries', $new_entry);
            $_entry_id = $wpdb->insert_id;
            update_post_meta($post_id, '_entry_id', $_entry_id);
        }

        $formId = $_POST['formId'];
        $sql_form_info = "SELECT config from ".$this->caldera_forms." WHERE form_id='".$formId."' and type='primary'";
        $fields = unserialize($wpdb->get_results($sql_form_info, 'ARRAY_A')[0]['config'])['fields'];

        $sql_current_values = "SELECT field_id, value FROM ". $this->caldera_entries . " WHERE entry_id='".$_entry_id."'";
        $current_values = $wpdb->get_results($sql_current_values, 'ARRAY_A');

        $msg = "";
        foreach ($_POST as $index => $value)
        {
            $old_value = '';
            if(strpos($index, 'fld_') !== false)
            {
                $sql_exists = "SELECT count(field_id) AS count FROM ".$this->caldera_entries." WHERE field_id='$index' AND entry_id=$_entry_id";
                $count = $wpdb->get_results($sql_exists, 'ARRAY_A')[0]['count'];
                if($count > 0)
                {//Exists
                    if(!is_array($value))
                    {//Others
                        $alt_vals = explode(",", $value);
                        if(($index_autocomplete = array_search( "autocomplete", $alt_vals)) !== false)
                        {
                            $this->insert_autocomplete($alt_vals, $index, $index_autocomplete, $_entry_id, $msg, $fields, $wpdb, $current_values);
                        }else
                        {
                            $return = $this->search_in_array($current_values, $index);
                            if(is_array($return))
                            {
                                $old_value = $return[0];
                            }

                            if($old_value != $value)
                            {
                                if(!empty($old_value))
                                {
                                    $old_value .= " <u>para</u> ";
                                }

                                $msg .= $fields[$index]['label'].": $old_value $value <br/>";

                                if(!is_numeric($value))
                                {
                                    $value = "'".$value."'";
                                }

                                $sql = "UPDATE ".$this->caldera_entries." SET value=".$value." where entry_id=".$_entry_id." and field_id='".$index."'";

                                $wpdb->query($sql);
                            }
                        }
                    } else {
                        //Checkbox
                        $delete_sql = "DELETE FROM ".$this->caldera_entries." WHERE field_id='".$index."'";
                        $wpdb->query($delete_sql);

                        $return = $this->search_in_array($current_values, $index);

                        if(is_array($return))
                        {
                            $old_value = $return[0];
                            foreach ($return as $option)
                            {
                                if(!in_array($option, $value))
                                {
                                    $msg .= $fields[$index]['label'].":<br/>";
                                    foreach ($value as $v)
                                    {
                                        $msg .= "$v<br>";
                                    }
                                    break;
                                }
                            }

                        }

                        $index = "'".$index."'";
                        $slug = "'".$fields[$index]['slug']."'";
                        foreach($value as $v)
                        {
                            $v = "'".$v."'";
                            $sql = "INSERT INTO ".$this->caldera_entries." (entry_id, field_id, slug, value) VALUES ($_entry_id, $index, $slug, $v)";
                            $wpdb->query($sql);
                        }
                    }


                }else //New
                {
                    if(!empty($fields[$index]['slug']) && !empty($_entry_id))
                    {
                        $msg .= $fields[$index]['label'].": $value <br/>";
                        $slug = "'".$fields[$index]['slug']."'";
                        $index = "'".$index."'";

                        if(!is_array($value))
                        {
                            $alt_vals = explode(",", $value);
                            if(($index_autocomplete = array_search( "autocomplete", $alt_vals)) !== false)
                            {
                                unset($alt_vals[$index_autocomplete]);
                                foreach ($alt_vals as $alt_val){
                                    if(!is_numeric($alt_val))
                                    {
                                        $alt_val = "'".$alt_val."'";
                                    }

                                    $sql = "INSERT INTO ".$this->caldera_entries." (entry_id, field_id, slug, value) 
                                    VALUES ($_entry_id, $index, $slug, $alt_val)";
                                    $wpdb->query($sql);
                                }
                            } else {
                                $value = "'".$value."'";

                                $sql = "INSERT INTO ".$this->caldera_entries." (entry_id, field_id, slug, value) 
                                VALUES ($_entry_id, $index, $slug, $value)";
                                $wpdb->query($sql);
                            }
                        }else
                        {
                            foreach($value as $v)
                            {
                                $msg .= "$v<br>";
                                $v = "'".$v."'";
                                $sql = "INSERT INTO ".$this->caldera_entries." (entry_id, field_id, slug, value) 
                                VALUES ($_entry_id, $index, $slug, $v)";
                                $wpdb->query($sql);
                            }
                        }
                    }
                }
            }else if($index == 'file_value') {//Saving files
                $files = json_decode(stripslashes($value));

                foreach ($files as $file)
                {
                    $upload_dir = wp_upload_dir();
                    $file_name = $file->name;
                    $file_content = end(explode("base64,", $file->file));
                    $file_content = base64_decode($file_content);
                    $path = $upload_dir['path']."/$file_name";
                    $url_path = $path;

                    $i = 1;
                    while (file_exists($path))
                    {
                        $name = pathinfo($file_name, PATHINFO_FILENAME);
                        $extension = pathinfo($file_name,PATHINFO_EXTENSION);
                        $path = $upload_dir['path']."/$name-$i.$extension";
                        $url_path = $upload_dir['url']."/$name-$i.$extension";
                        $i++;
                    }

                    if(file_put_contents($path, $file_content))
                    {
                        $caldera_entries = $this->caldera_entries;
                        $file_input_id = $_POST['file_input_id'];
                        $slug = "'".$fields[$file_input_id]['slug']."'";
                        if(!empty($slug))
                        {
                            $sql_insert = "INSERT INTO $caldera_entries (entry_id, field_id, slug, value) VALUES ('$_entry_id', '$file_input_id', $slug, '$url_path')";
                            $wpdb->query($sql_insert);
                        }
                    }
                }
            }

        }

        if(!empty($msg))
        {
            $msg .= "<br><br>";
            $AcolheSUSLogger->log($post_id, ' salvou o formulário ', $msg);
        }

        wp_publish_post($post_id);
    }

    function insert_autocomplete(&$alt_vals, $index, $index_autocomplete, $_entry_id, &$msg, $fields, $wpdb, &$current_values)
    {
        unset($alt_vals[$index_autocomplete]);
        $return = $this->search_in_array($current_values, $index);

        $array_diff1 = array_diff($return, $alt_vals);
        $array_diff2 = array_diff($alt_vals, $return);

        if(!empty($array_diff1) || !empty($array_diff2))
        {
            $old_value = implode(", ", $return);
            $old_value .= " <u>para</u> ";
            $old_value .= implode(", ", $alt_vals);
            $msg .= $fields[$index]['label'].": $old_value <br/>";

            $delete_sql = "DELETE FROM ".$this->caldera_entries." WHERE field_id='".$index."'";
            $wpdb->query($delete_sql);

            foreach ($alt_vals as $alt_val){
                if(!is_numeric($alt_val))
                {
                    $alt_val = "'".$alt_val."'";
                }

                $slug = "'".$fields[$index]['slug']."'";
                $sql = "INSERT INTO ".$this->caldera_entries." (entry_id, field_id, slug, value) VALUES ($_entry_id, '".$index."', $slug, $alt_val)";
                $wpdb->query($sql);
            }
        }
    }

    function search_in_array(&$current_value, $search)
    {
        $results = [];
        foreach ($current_value as $value)
        {
            if($value['field_id'] == $search && $value['value'] != '')
            {
                $results[] =  $value['value'];
            }
        }

        if(empty($results))
        {
            return false;
        }

        return $results;
    }

    function delete_new_form_tag() {
        if (is_user_logged_in() && isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
            delete_post_meta($_POST['post_id'], 'new_form');
        }
    }

    function delete_form_attachment() {
        if (is_user_logged_in() && isset($_POST['attach']) && isset($_POST['entry'])) {
            global $wpdb;
            $caldera_entries = $this->caldera_entries;

            $id = $_POST['attach'];
            $entry = $_POST['entry'];

            $wpdb->query("DELETE FROM " . $caldera_entries . " WHERE id = '$id' AND entry_id='$entry'");
        }
    }

    protected function get_attachments($field_id) {
        if ($form_id = get_the_ID()) {
            $entry = get_post_meta($form_id, '_entry_id', true);
            if ($entry) {
                global $wpdb;
                $caldera_entries = $wpdb->prefix . 'cf_form_entry_values';
                $atts = $wpdb->get_results("SELECT id, value FROM " . $caldera_entries . " WHERE field_id = '$field_id' AND entry_id = '$entry'", ARRAY_A);

                return $atts;
            }
        }
        return false;
    }

    function acolhesus_add_entry_btn_callback($type) {
        if (!is_null($type) && $this->can_add_entry($type)) {
            $obj = get_post_type_object($type);
            if ($obj instanceof WP_Post_Type && $this->can_user_edit($type)) {
                $f_name = $obj->labels->singular_name; ?>
                <div class="add-entry">
                    <button class="add_acolhesus_entry btn" data-newTitle="<?php echo $f_name ?>" data-postType="<?php echo $type; ?>">
                        Adicionar <?php echo $f_name ?>
                    </button>
                </div>
                <?php
            }
        }
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
                            'acolhesus_fase' => (is_array($form['fase']))? implode(',', $form['fase']) : $form['fase']
                        ];
                        $this->add_acolhesus_entry($title, $formName, 'publish', $metas);
                    }
                }
            }
        }
    }

    function acolhesus_rewrite_reports() {
        if ($form = $this->is_report_page(true)) {
            require_once (plugin_dir_path( __FILE__ ) . "relatorios.php");
            die();
        }
    }

    private function is_report_page($return_form = false)
    {
        $_uri = explode('/', $_SERVER['REQUEST_URI']);
        $page = array_pop($_uri);
        $form = array_pop($_uri);
        $is_report_page = is_string($page) && ("relatorio" === $page) && post_type_exists($form) && array_key_exists($form,$this->forms);

        if ($is_report_page && $return_form)
            return $form;

        return $is_report_page;
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

    /*
    function limit_paragraphs_input($attrs) {
        $attrs[ 'maxlength' ] = 6000;
        return $attrs;
    }

    private function limit_paragraphs($formType) {
        $limit_paragraph = ["avaliacao_grupos", "avaliacao_oficina"];
        if (in_array($formType, $limit_paragraph)) {
            add_filter('caldera_forms_field_attributes-paragraph', array(&$this, 'limit_paragraphs_input'));
        }
    } */

    function filter_the_content($content) {
        global $post;
        $formType = get_post_type();
        $_post_id = $post->ID;

        if (is_single() && $this->isAcolheSusPage()) {

            if (!$this->user_can_view($formType, get_the_title()))
                return;

            $form = "<br>";

            $this->lock_form($_post_id, $formType);
            // $this->limit_paragraphs($formType);

            $form .= $this->render_fixed_meta($_post_id, $formType);

            $this->render_form_cities($_post_id, $formType);
            $created_form = $this->get_entry_form($_post_id, $formType);
            $form .= $created_form;

            if (!$this->is_entry_locked($_post_id) && !empty($created_form) && $this->can_save_incomplete($formType)) {
                $permissions = get_user_meta(get_current_user_id(), 'acolhesus_form_perms');
                if(in_array("editar_".$formType, $permissions))
                {
                    $form .= '<button class="save_for_later btn btn-info" type="button">Salvar</button>';
                }
            }

            $form .= "<div id='acolhesus_form_anexos'></div>";

            return $content . $form;
        }

        return $content;
    }

    private function can_save_incomplete($formType) {
        $flag = 'can_not_save_incomplete';
        $form = $this->forms[$formType];

        return (!is_null($form) && !(isset($form[$flag]) && $form[$flag]));
    }

    private function render_fixed_meta($_post_id, $formType) {
        $extra_info = "";
        if (isset($this->forms[$formType]) && (true !== $this->forms[$formType]['uma_entrada_por_campo']) ) {
            // Variável que caldera forms envia após submit do form
            if (!isset($_GET['cf_su'])) {
                $permissions = get_user_meta(get_current_user_id(), 'acolhesus_form_perms');
                if(in_array("editar_".$formType, $permissions))
                {
                    $is_locked = false;
                }else $is_locked = true;
                //$is_locked = $this->is_entry_locked($_post_id);

                $extra_info = "<div class='col-md-12 fixed-meta'>" . $this->get_basic_info_form($is_locked) . "</div>";
            }
        }

        if ("matriz_cenario" === $formType) {
            $cities = get_post_meta($_post_id, 'acolhesus_form_municipio');
            $total = count($cities);
            $municipios = json_encode($cities, JSON_UNESCAPED_UNICODE);

            $extra_input  = "<input type='hidden' id='entry_cities' name='entry_cities' value='$municipios'>";
            $extra_input .= "<input type='hidden' id='total_entry_cities' name='total_entry_cities' value='$total'>";

            echo $extra_input;
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
            $_title = "Municípios de abrangência da unidade";
            echo "<div class='col-md-6 no-padding cities-mc' id='form_id' data-id='$id'><label for='municipios-matriz-cenario'> $_title </label> " .$this->span_required() . " <br>";
            echo "<select multiple name='municipios-matriz-cenario' class='matriz-cenario-cities form-controle'> $uf_cities </select>";
            echo $this->required_field() . "</div>";
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

    function remove_form_entry() {
        if ($this->isCGPNH() && isset($_POST['id'])) {
            $r = wp_delete_post(sanitize_text_field($_POST['id']));

            if ($r) {
                return json_encode(['success' => 'Resposta apagada com sucesso!']);
            }
        }
    }

    function get_campos_do_usuario_as_options($selected = '') {
        $camposDoUsuario = $this->get_user_campos();
        $options = '';
        if (is_single()) {
            $options = "<option value=''></option>";
        }

        foreach ($camposDoUsuario as $campo) {
            if (array_key_exists($campo, $this->campos_completos)) {
                $campo_completo = $this->campos_completos[$campo];
                $options .= "<option value='$campo'";
                $options .= selected($selected, $campo, false);
                $options .= "> $campo_completo </option>\n";
            }
        }
        return $options;
    }

    function get_eixos_as_options($selected = '') {
        $options = '';
        if (is_single()) {
            $options = "<option value=''></option>";
        }
        foreach ($this->eixos as $eixo) {
            $options .= "<option value='$eixo'";
            $options .= selected($selected, $eixo, false);
            $options .= ">$eixo</option>\n";
        }
        return $options;
    }

    function get_forms_as_options($selected = '') {
        $options = '';
        foreach ($this->forms as $_f) {
            $slug = $_f['slug'];
            if($slug === 'poster') continue;
            if ($this->can_user_see($slug)) {
                $nome = $_f['labels']['name'];
                $options .= "<option value='$slug'";
                $options .= selected($selected, $slug, false);
                $options .= ">$nome</option>\n";
            }
        }

        return $options;
    }

    function get_fases_as_options($selected = '') {
        $options = '';
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

    function get_filter_options($filter, $selected = '') {
        $options = '';
        switch ($filter) {
            case 'campo':
                $options = $this->get_campos_do_usuario_as_options($selected);
                break;
            case 'eixo':
                $options = $this->get_eixos_as_options($selected);
                break;
            case 'fase':
                $options = $this->get_fases_as_options($selected);
                break;
            case 'form':
                $options = $this->get_forms_as_options($selected);
                break;
        }

        return $options;
    }

    function get_filter_selected($filter, $value = '') {
        if (!empty($value)) {
            $selected = "";
            switch ($filter) {
                case 'campo':
                    $selected = $this->campos_completos[$value];
                    break;
                case 'eixo':
                    $selected = $value;
                    break;
                case 'fase':
                    $selected = $this->fases[$value];
                    break;
                case 'form':
                    $selected = $this->forms[$value]['labels']['singular_name'];
                    break;
            }

            return $selected;
        }
    }

    private function get_basic_info_form($is_locked = false) {
        global $post;

        $attr  = ($is_locked) ? "disabled='disabled'": '';
        $attr .= " required";
        $type = get_post_type();

        $campoAtual = get_post_meta($post->ID, self::CAMPO_META, true);
        $faseAtual = get_post_meta($post->ID, 'acolhesus_fase', true);

        if($is_locked === false || $faseAtual)
        {
            $options = $this->get_campos_do_usuario_as_options($campoAtual);
            $camposHtml = $this->get_fixed_select("Campo de atuação", "acolhesus_campo", $attr, $post->ID, $options);
        }else  $camposHtml = '';

        if($faseAtual || $is_locked === false)
        {
            $options = $this->get_fases_as_options($faseAtual);
            $faseHtml = $this->get_fixed_select("Fase", "acolhesus_fase", $attr, $post->ID, $options);
        }else $faseHtml = '';

        if ($this->form_type_has_axis($type)) {
            $eixoAtual = get_post_meta($post->ID, 'acolhesus_eixo', true);
            $options = $this->get_eixos_as_options($eixoAtual);
            $eixoHtml = $this->get_fixed_select("Eixo", "acolhesus_eixo", $attr, $post->ID, $options);
        } else {
            $eixoHtml = "";
        }

        return $camposHtml . $faseHtml . $eixoHtml;
    }

    private function get_fixed_select($title, $name, $attr, $post_id, $options=[]) {
        $num_rows = 6;
        if ($this->form_type_has_axis(get_post_type())) {
            $num_rows = 4;
        }

        $id = $name . "_selector";
        $html  = "<div class='col-md-$num_rows $name'> $title " . $this->span_required();
        $html .= "<select id='$id' $attr class='acolhesus_basic_info_selector' name='$name' data-post_id='$post_id'>";
        $html .= $options . " </select>";
        $html .= $this->required_field();
        $html .= "</div>";

        return $html;
    }

    private function required_field() {
        return "<div class='fixed field_required'> Campo obrigatório!</div>";
    }

    private function span_required() {
        return "<span class='field_required'>*</span>";
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
            $metas = ['acolhesus_campo' => array_shift($user_campos), 'new_form' => true];
            $_id = $this->add_acolhesus_entry($_POST['title'], $_POST['type'], 'publish', $metas);
            if ($_id) {
                echo json_encode(['id' => $_id, 'redirect_url' => get_permalink($_id)]);
                $post = array( 'ID' => $_id, 'post_status' => 'draft' );
                wp_update_post($post);
                wp_die();
            }
        } else {
            echo json_encode(['error' => 'Usuário não habilitado para criar nova resposta']);
        }

        return false;
    }

    function ajax_callback_lock_form() {
        if ($this->isCGPNH()) {
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
        if(get_post_meta($_id, "acolhe_sus_add_as_saved", true) == 1)
        {
            if (update_post_meta($_id, "locked", !$toggle)) {
                $estado = (!$toggle) ? "fechado" : "aberto";
                echo json_encode([
                    'success' => "Formulário $estado para edição!",
                    'list' => $this->get_entry_strings($_id)
                ]);
                do_action('acolhesus_toggle_lock_entry', $_id, !$toggle);
            }

            wp_die();
        }else {
            echo json_encode([
                'warning' => "Há campos obrigratórios não preenchidos"
            ]);
            wp_die();
        }
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
        $is_plugin_home = ("formularios" === get_query_var('acolhe_sus'));
        $is_form_page = is_object($post) && isset($post->post_type) && array_key_exists($post->post_type, $this->forms);
        return ($is_form_page || $is_plugin_home || $this->is_report_page());
    }

    function load_acolhesus_assets() {
        // global $wp;  
        // $current_url = home_url(add_query_arg(array(),$wp->request));
        if ($this->isAcolheSusPage()) {
            wp_enqueue_style( 'rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/css/acolhesus.css');
        }

        if ($this->is_report_page() || $this->isAcolheSusPage()) {
            wp_enqueue_script( 'rhs-acolhesus-reports', plugin_dir_url( __FILE__ ) . 'assets/js/reports.js',array('jquery'));
            wp_enqueue_script( 'rhs-acolhesus-boards',  plugin_dir_url( __FILE__ ) . 'assets/js/reports/boards.js',array('jquery'));
            wp_enqueue_script('google_charts', 'https://www.gstatic.com/charts/loader.js');
            wp_localize_script('rhs-acolhesus-reports', 'acolhesus', [
                'ajax_url' => admin_url('admin-ajax.php')
            ]);
        }

        $type = get_post_type();
        if ( $type && array_key_exists($type, $this->forms)  || !empty(get_query_var('acolhe_sus')) ) {

            wp_enqueue_script('jquery-ui-accordion', null, array('jquery'), null, false);

            if (is_single()) {
                wp_enqueue_script('rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/js/single.js', array('jquery', 'jquery-ui-accordion'));

                if ("matriz_cenario" === $type) {
                    wp_enqueue_style('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.css');
                    wp_enqueue_script('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.js', array('jquery'));
                }

            } else if ( is_archive() || !empty(get_query_var('acolhe_sus')) ) {
                wp_enqueue_script( 'rhs-acolhesus', plugin_dir_url( __FILE__ ) . 'assets/js/archive.js');
                wp_enqueue_style('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.css');
                wp_enqueue_script('select2', plugin_dir_url( __FILE__ ) . 'assets/lib/select2/select2.min.js', array('jquery'));
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
            if ($this->isRespondent()) {
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

                /*
                 * Comentar por enquanto, até definirmos exatamente como vai funcionar essa questão dos eixos
                 * Até o momento, apenas dois forms terão eixo, e este valor não será armazenado no banco de dados
                 *
                if (isset($_GET['eixo']) && !empty($_GET['eixo'])) {
                    $meta_query[] = [
                        'key' => 'acolhesus_eixo',
                        'value' => $_GET['eixo'],
                    ];
                }
                */

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

    public function user_can_see_states() {
        return is_array($this->get_user_campos()) && (count($this->get_user_campos()) > 0);
    }

    public function get_user_forms_perms($userID = null) {
        if (is_null($userID))
            $userID = get_current_user_id();

        return get_user_meta($userID, 'acolhesus_form_perms');
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
    public function remove_entry($entry_id) {
        $title = get_the_title($entry_id);
        return "<a class='remove-form-entry btn btn-default btn-danger' data-id='$entry_id' data-title='$title' style='color: white'> Excluir </a>";
    }

    public function get_entry_phase($id) {
        $fase_slug = get_post_meta($id, 'acolhesus_fase', true);
        $fase = empty($fase_slug) ? "----" : $this->fases[$fase_slug];

        return $fase;
    }

    public function get_entry_date($id)
    {
        global $wpdb;
        $is_empty = "----";
        $sql_entry_id = "SELECT meta_value as entry_id FROM $wpdb->postmeta WHERE post_id = ".$id." AND meta_key = '_entry_id'";

        $result = $wpdb->get_results($sql_entry_id);

        if(!empty($result))
        {
            $entry_id = $result[0]->entry_id;
            $sql = "SELECT entry_a.entry_id, entry_a.value mes, entry_b.value ano
                    FROM ".$this->caldera_entries." as entry_a join ".$this->caldera_entries." as entry_b
                    where entry_a.slug='mes' AND entry_b.slug='ano' AND entry_a.entry_id=entry_b.entry_id AND entry_a.entry_id='".$entry_id."'";

            $data = $wpdb->get_results($sql);
            if(!empty($data))
            {
                echo $data[0]->mes."/".$data[0]->ano;
            } else echo $is_empty;

        } else echo $is_empty;
    }

    public function get_entry_axis($id) {
        return get_post_meta($id, 'acolhesus_eixo', true);
    }

    public function form_type_has_axis($type) {
        if ($type) {
            return (isset($this->forms[$type]) && $this->forms[$type]['eixo']);
        }
    }

    public function isAdmin() {
        return (current_user_can('administrator') || current_user_can('editor'));
    }

    public function isCGPNH() {
        return current_user_can(self::CGPNH);
    }

    public function isRespondent() {
        return current_user_can(self::RESPONDENT);
    }

    public function showMonthYear($formSlug) {
        $showableForms = $this->getOcurrenceForms();

        return in_array($formSlug, $showableForms);
    }

    public function getOcurrenceForms() {
        return ["indicadores", "indicadores_caps", "ind_materno_infantil", "indicadores_basica", "relatorio_oficina", "avaliacao_oficina", "avaliacao_grupos", "memoria_reuniao","atividades_dispersao"];
    }

    private function getCityPopulation($form_id) {
        global $wpdb;
        $populacao = 0;

        $sql = "SELECT sum(populacao) populacao from municipio where id in
                       (SELECT meta_value from $wpdb->postmeta where meta_key='acolhesus_form_municipio' and post_id=$form_id)";
        $r = $wpdb->get_results($sql, ARRAY_A);

        if(!empty($r)) {
            $populacao = $r[0]['populacao'];
        }

        return $populacao;
    }

    private function getCitiesCount($form_id) {
        global $wpdb;
        $count_cities = 0;

        $sql = "SELECT count(*) as count from $wpdb->postmeta where meta_key='acolhesus_form_municipio' and post_id=$form_id";
        $r = $wpdb->get_results($sql, ARRAY_A);

        if(!empty($r)) {
            $count_cities = $r[0]['count'];
        }

        return $count_cities;
    }

} // class

include('acolhesus-view.php');
include('admin-forms.php');
include('logger.php');

global $AcolheSUS;
$AcolheSUS = new AcolheSUS();
$formView = new AcolheSUSView();