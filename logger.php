<?php

class AcolheSUSLogger {

    public $edit_session = '';
    public $edit_session_action = '';

    public function __construct() {

		add_filter('caldera_forms_save_field', [&$this, 'save_field'], 10, 4);
        
        
        add_filter('caldera_forms_update_field', [&$this, 'update_field'], 10, 3);

        add_action('caldera_forms_submit_complete', [&$this, 'save_entry_begin'], 1, 4);
        add_action('caldera_forms_submit_complete', [&$this, 'save_entry_end'], 99, 4);
        
    }
    
    function get_post_id_by_entry_id($entryid) {

        global $wpdb;
        return $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", '_entry_id', $entryid));

    }

    function save_entry_begin($form, $referrer, $process_id, $entryid) {
        if (isset($_POST['_cf_frm_edt'])) {
            $this->edit_session_action = 'edit';
        } else {
            $this->edit_session_action = 'add';
        }
        $this->edit_session = '';
    }

    function save_entry_end($form, $referrer, $process_id, $entryid) {
        $post_id = $this->get_post_id_by_entry_id($entryid);
        
        
        if ($this->edit_session_action == 'edit') {
            $action = 'editou as respostas';
        } elseif ($this->edit_session_action == 'add') {
            $action = 'criou estas respostas';
        }
        $message = $this->edit_session;
        
        //$this->log($post_id, $action, $message);
    }

    function save_field($entry, $field, $form, $entry_id) {
        $this->edit_session .= $field['label'] . ': ' . $entry . '<br/>';
        return $entry;

    }

    function update_field($newdata, $field, $form) {
        
        $this->edit_session .= $field['label'] . ': ' . $newdata . '<br/>';
        
        return $newdata;
    }



    function log($post_id, $action, $message, $user_id = null) {

        if (is_null($user_id)) {
            $user_id = get_current_user_id();
        }

        $user = get_userdata( $user_id );

        $content = $user->display_name . ' ' . $action . '<br/><br/>';

        $comment_id = wp_new_comment( [
            'comment_post_ID' => $post_id,
            'user_id' => $user_id,
            'comment_content' => $content . $message,
            'comment_author' => $user->display_name,
            'comment_author_url' => $user->user_url,
            'comment_author_email' => $user->user_email
        ] );
        

    }

	

}

global $AcolheSUSLogger;
$AcolheSUSLogger = new AcolheSUSLogger();
