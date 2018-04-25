<?php


class AcolheSUSAdminForm {
    public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_settings'  ) );

	}

	public function add_admin_menu() {

		add_menu_page(
			esc_html__( 'AcolheSUS', 'text_domain' ),
			esc_html__( 'Opções dos Formulários', 'text_domain' ),
			'manage_options',
			'test-options',
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

		// Check required user capability
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'text_domain' ) );
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

        $forms = $AcolheSUS->forms;

        $form_ids = $this->get_option('form_ids');

        foreach ($forms as $formName => $form) {
            
            echo $formName, ': <input type="text" name="acolhesus[form_ids][', $formName, ']" value="', $form['form_id'], '" /><br/>';
        }

    }
    

    // OPTION HELPER

    function get_option($name) {
        
        $defaults = [
            'form_ids' => []
        ];
        
        $options = array_merge($defaults, get_option( 'acolhesus' ));
        
        if (isset($options[$name]))
            return $options[$name];
        return '';
    }
}

global $AcolheSUSAdminForm;
$AcolheSUSAdminForm = new AcolheSUSAdminForm();
