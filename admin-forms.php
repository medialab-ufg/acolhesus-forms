<?php

class AcolheSUSAdminForm {

    const PLUGIN_OPTION_NAME = 'acolhesus';

    public $customCaps = [
        'view_acolhesus' => [
            'label' => 'Permissão básica que permite ver a página de formulários'
        ],
        'acolhesus_cgpnh' => [
            'label' => 'Membro da Equipe CGPNH'
        ],
    ];

    public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'init_settings'  ) );
        
        add_action( 'edit_user_profile', array( &$this, 'extra_profile_fields' ) );
        add_action( 'show_user_profile', array( &$this, 'extra_profile_fields' ) );

        add_action( 'personal_options_update', array( &$this, 'save_extra_profile_fields' ) );
        add_action( 'edit_user_profile_update', array( &$this, 'save_extra_profile_fields' ) );

	}

	public function add_admin_menu() {

		add_menu_page(
			esc_html__( 'AcolheSUS', 'acolhesus-rhs' ),
			esc_html__( 'Opções AcolheSUS', 'acolhesus-rhs' ),
			'manage_options',
			'acolhesus-config',
			array( $this, 'page_layout' ),
			'',
			99
		);

	}

	public function init_settings() {

		register_setting(
			'acolhesus_group',
			'acolhesus'
		);

		add_settings_section(
			'acolhesus_section',
			'',
			false,
			'acolhesus'
		);

		add_settings_field(
			'acolhesus',
			'IDs dos formulários',
			array( $this, 'render_acolhesus_field' ),
			'acolhesus',
			'acolhesus_section'
		);

	}

	public function page_layout() {

		// Verificar se é essa permissão mesmo
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'acolhesus-rhs' ) );
		}

		// Admin Page Layout
		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . get_admin_page_title() . '</h1>' . "\n";
		echo '	<form action="options.php" method="post">' . "\n";

        settings_fields( 'acolhesus_group' );
        
        do_settings_sections( 'acolhesus' );
		submit_button();

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}

	function render_acolhesus_field() {

		// Retrieve data from the database.
        global $AcolheSUS;

        $registered_forms = Caldera_Forms::get_forms();
        foreach($registered_forms as $f) {
            echo  '<strong>', $f['name'] . '</strong> (' . $f['ID'] . ') | ';
        }

        echo "<hr/>";

        if(is_array($registered_forms) && count($registered_forms) > 0 ) {
            $forms = $AcolheSUS->forms;

            $form_ids = $this->get_acolhesus_option('form_ids');

            foreach ($forms as $formName => $form) {
                echo $formName, ' <input type="text" name="acolhesus[form_ids][', $formName, ']" value="', $form['form_id'], '" /><br/><br/>';
            }
        }
    }

    // OPTION HELPER
    function get_acolhesus_option($name) {
        
        $defaults = [
            'form_ids' => []
        ];
        $config = get_option(self::PLUGIN_OPTION_NAME);
        if (is_array($config)) {
            $options = array_merge($defaults, get_option( 'acolhesus' ));
        }
        
        if (isset($options[$name]))
            return $options[$name];
        return '';
    }

    ////////////////////////// USERS ///////////////////////////////

    function extra_profile_fields($user) {
        
        global $AcolheSUS;

        $campos = $AcolheSUS->campos;
        $camposSalvos = get_user_meta($user->ID, 'acolhesus_campos');

        ?>
        <table class="form-table field-add">
            <tbody>
            <tr class="user-links">
                <th>
                    <label for="links">Permissões Acolhe SUS</label>

                </th>
                <td>
                    <div class="panel-body">
                        
                        <h4>Permissões adicionais (custom capabilities)</h4>
                        
                        <?php foreach ($this->customCaps as $cap => $props): ?>

                            <input type="checkbox" name="acolhesus_caps[]" value="<?php echo $cap; ?>"
                                <?php if (user_can($user->ID, $cap)) echo "checked"; ?>
                            />
                            <?php echo $props['label']; ?> (<?php echo $cap; ?>)
                            <br>

                        <?php endforeach; ?>
                        
                        
                        
                        <h4>Quais Campos de atuação esse usuário pode ver:</h4>

                        <?php foreach ($campos as $campo): ?>

                            <input type="checkbox" name="acolhesus_campos[]" value="<?php echo $campo; ?>"
                                <?php if (in_array($campo, $camposSalvos)) echo "checked"; ?>
                            />
                            <?php echo $campo; ?>
                            <br>

                        <?php endforeach; ?>

                    </div>
                </td>
            </tr>

            
            
            </tbody>
        </table>
        <?php
    }

    function save_extra_profile_fields( $userID ) {

        if ( ! current_user_can( 'edit_user', $userID ) ) {
            return false;
        }

        delete_user_meta($userID, 'acolhesus_campos');

        if (isset($_POST['acolhesus_campos']) && is_array($_POST['acolhesus_campos'])) {

            foreach ($_POST['acolhesus_campos'] as $campo) {
                add_user_meta($userID, 'acolhesus_campos', $campo);
            }

        }

        $user = get_userdata($userID);

        foreach ($this->customCaps as $cap => $props) {

            if (isset($_POST['acolhesus_caps']) && is_array($_POST['acolhesus_caps']) && in_array($cap, $_POST['acolhesus_caps'])) {
                $user->add_cap($cap);
            } else {
                $user->remove_cap($cap);
            }

        }

    }

}

global $AcolheSUSAdminForm;
$AcolheSUSAdminForm = new AcolheSUSAdminForm();
