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
			esc_html__( 'Configuração dos Formulários AcolheSUS', 'acolhesus-rhs' ),
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

        if (!class_exists('Caldera_Forms')) {
            $link = "<a href='https://wordpress.org/plugins/caldera-forms/' target='_blank'> Caldera Forms </a>";
            echo "Antes de continuar, certifique-se de que o $link esteja instalado e ativo!";
            wp_die();
        } else {
            $registered_forms = Caldera_Forms::get_forms();
            if(is_array($registered_forms) && count($registered_forms) > 0 ) {
                $forms = $AcolheSUS->forms;

                foreach ($forms as $formName => $form) {
                    echo $form['labels']['name'] . ": ";
                    $f_name = "acolhesus[form_ids][$formName]";
                    echo "<select name='$f_name'><option></option>";
                    foreach($registered_forms as $f) {
                        $id = $f['ID'];
                        $nome = $f['name'];
                        $selected = ($form['form_id'] == $id) ? "selected" : "";

                        echo  "<option value='$id' $selected> $nome </option>";
                    }
                    echo "</select><br>";
                }
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
        $forms = $AcolheSUS->forms;
        $camposSalvos = $AcolheSUS->get_user_campos($user->ID);
        $formPerms = $AcolheSUS->get_user_forms_perms($user->ID);
        ?>

        <table class="form-table field-add">
            <tbody>
            <tr class="user-links">
                <th> <label for="links"> Permissões Acolhe SUS </label> </th>
                <td>
                    <div class="panel-body">

                        <h4> Permissões adicionais </h4>
                        <?php foreach ($this->customCaps as $cap => $props): ?>
                            <input type="checkbox" name="acolhesus_caps[]" value="<?php echo $cap; ?>"
                                <?php if (user_can($user->ID, $cap)) echo "checked"; ?>
                            />
                            <?php echo $props['label']; ?> (<?php echo $cap; ?>) <br>
                        <?php endforeach; ?>

                        <h4> Marque os campos de atuação que este usuário pode ver: </h4>
                        <?php foreach ($campos as $campo): ?>
                            <input type="checkbox" name="acolhesus_campos[]" value="<?php echo $campo; ?>"
                                <?php if (in_array($campo, $camposSalvos)) echo "checked"; ?>
                            />
                            <?php echo $campo; ?> <br>
                        <?php endforeach; ?>

                        <hr>

                        <h4> Marque os formulários que este usuário pode ver/editar: </h4>
                        <?php
                        foreach ($forms as $slug => $attrs):
                            $_f = [
                                    'view' => 'ver_' . $attrs['slug'],
                                    'edit' => 'editar_' . $attrs['slug']
                            ];
                            ?>
                            <h3> <?php echo $attrs['labels']['name']; ?> </h3>
                            <div>
                                <input id='see_form' type="checkbox" name="acolhesus_form_perms[]"
                                       value="<?php echo $_f['view'] ?>"  <?php if (in_array($_f['view'], $formPerms)) echo "checked"; ?> />
                                <label for="see_form"> Ver </label> <br>

                                <input id='edit_form' type="checkbox" name="acolhesus_form_perms[]"
                                       value="<?php echo $_f['edit'] ?>" <?php if (in_array($_f['edit'], $formPerms)) echo "checked"; ?> />
                                <label for="edit_form">Editar</label>
                            </div>
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

        $this->update_uf_permissions($userID);
        $this->update_forms_permissions($userID);

        $user = get_userdata($userID);
        foreach ($this->customCaps as $cap => $props) {
            if (isset($_POST['acolhesus_caps']) && is_array($_POST['acolhesus_caps']) && in_array($cap, $_POST['acolhesus_caps'])) {
                $user->add_cap($cap);
            } else {
                $user->remove_cap($cap);
            }
        }
    }

    private function update_uf_permissions($userID) {
        delete_user_meta($userID, 'acolhesus_campos');

        if (isset($_POST['acolhesus_campos']) && is_array($_POST['acolhesus_campos'])) {
            foreach ($_POST['acolhesus_campos'] as $campo) {
                add_user_meta($userID, 'acolhesus_campos', $campo);
            }
        }
    }

    private function update_forms_permissions($userID) {
        delete_user_meta($userID, 'acolhesus_form_perms');

        if (isset($_POST['acolhesus_form_perms']) && is_array($_POST['acolhesus_form_perms'])) {
            foreach ($_POST['acolhesus_form_perms'] as $form_perm) {
                add_user_meta($userID, 'acolhesus_form_perms', $form_perm );

            }
        }
    }

}

global $AcolheSUSAdminForm;
$AcolheSUSAdminForm = new AcolheSUSAdminForm();
