<?php 
if( !defined( 'ABSPATH' ) ) exit;

class jtpp_share_buttons {
    private $options;
    private $success;
    private $errors;
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    // Add menu
    public function add_plugin_page() {
        add_options_page( __( "JTPP Share Buttons", "jtpp-share-buttons" ), __( "JTPP Share Buttons", "jtpp-share-buttons" ), 'manage_options', 'jtpp_share_buttons', array( $this, 'create_admin_page' ) );
    }

    // Setting page initialization
    public function page_init() {
        if( !function_exists( 'wp_get_current_user' ) ) {
            include( ABSPATH . "wp-includes/pluggable.php" ); 
        }
        if( current_user_can( 'manage_options' ) ) {
            // Get the setting of the DB
            $this->options = get_option( 'jtpp_share_buttons' );
            $this->errors = array();
            $this->success = "";
            // If the data is transmitted
            if( isset( $_POST['jtpp_share_buttons'] ) ) {
                $input = $_POST['jtpp_share_buttons'];
                $this->options['show_before_single'] = sanitize_text_field($input['show_before_single']);
                $this->options['show_after_single'] = sanitize_text_field( $input['show_after_single'] );
                $this->options['show_before_page'] = sanitize_text_field( $input['show_before_page'] );
                $this->options['show_after_page'] = sanitize_text_field( $input['show_after_page'] );
                $this->options['select_design'] = sanitize_text_field( $input['select_design'] );
                // Error If there is no value
                if( !isset( $this->options['show_before_single'] ) || $this->options['show_before_single'] === '' ) {
                    $this->errors['show_before_single'] = __( "Please select the item of \"Single posts\".", "jtpp-share-buttons" );
                }
                if( !isset( $this->options['show_after_single'] ) || $this->options['show_after_single'] === '' ) {
                    $this->errors['show_after_single'] = __( "Please select the item of \"Single posts\".", "jtpp-share-buttons" );
                }
                if( !isset( $this->options['show_before_page'] ) || $this->options['show_before_page'] === '' ) {
                    $this->errors['show_before_page'] = __( "Please select the item of \"Single pages\".", "jtpp-share-buttons" );
                }
                if( !isset( $this->options['show_after_page'] ) || $this->options['show_after_page'] === '' ) {
                    $this->errors['show_after_page'] = __( "Please select the item of \"Single pages\".", "jtpp-share-buttons" );
                }
                if( !isset( $this->options['select_design'] ) || $this->options['select_design'] === '' ) {
                    $this->errors['select_design'] = __( "Please select the item of \"Design\".", "jtpp-share-buttons" );
                }
    
                // Save the value if there is no error
                if( !$this->errors && check_admin_referer( 'jtpp_share_buttons', 'nonce_jtpp_share_buttons' ) ) {
                    update_option( 'jtpp_share_buttons', $this->options );
                    $this->success = __( "Your settings have been saved.", "jtpp-share-buttons" );
                }
            }
        }
    }

    // Setting page's HTML
    public function create_admin_page() {
        $show_before_single = isset( $this->options['show_before_single'] ) ? $this->options['show_before_single'] : "show";
        $show_after_single = isset( $this->options['show_after_single'] ) ? $this->options['show_after_single'] : "show";
        $show_before_page = isset( $this->options['show_before_page'] ) ? $this->options['show_before_page'] : "hide";
        $show_after_page = isset( $this->options['show_after_page'] ) ? $this->options['show_after_page'] : "hide";
        $select_design = isset( $this->options['select_design'] ) ? $this->options['select_design'] : "01";

        echo "<h1>" , __( "JTPP Share Buttons", "jtpp-share-buttons" ) , "</h1>" , PHP_EOL;
        echo "<div style=\"font-size:1.1em;margin-bottom:1em;\">" , PHP_EOL , __( "Show Share-buttons easily.", "jtpp-share-buttons" ) , PHP_EOL , "</div>" , PHP_EOL;

        // Display success message
        if( $this->success ) {
            echo "<div class=\"updated\"><p><strong>";
            esc_html_e($this->success);
            echo "</strong></p></div>" , PHP_EOL;
        }
        // Display error message
        if( $this->errors ) {
            foreach ($this->errors as $err) {
                echo "<div class=\"error\"><p><strong>";
                esc_html_e($err);
                echo "</strong></p></div>" , PHP_EOL;
            }
        }

?>
<style>
input[type="radio"] {
    margin-left:1em;
}
</style>
<form method="post">
<?php wp_nonce_field( 'jtpp_share_buttons', 'nonce_jtpp_share_buttons' ); ?>
<div style="padding:1em 0 1em 2em;">
<h2><?php _e( "Single posts", "jtpp-share-buttons" ); ?></h2>
<p>
<?php _e( "Please select \"Show\" or \"Hide\" about share-buttons in single posts.", "jtpp-share-buttons" ); ?>
</p>
<h3><?php _e( "Before the content", "jtpp-share-buttons" ); ?></h3>
<?php _e( "Default is \"Show\".", "jtpp-share-buttons" ); ?>
<div style="padding:1em 0;">
<input type="radio" name="jtpp_share_buttons[show_before_single]" value="show"<?php if( $show_before_single != "hide" ) echo " checked=\"checked\"" ?> /><?php _e( "Show", "jtpp-share-buttons" ); ?>
<input type="radio" name="jtpp_share_buttons[show_before_single]" value="hide"<?php if( $show_before_single == "hide" ) echo " checked=\"checked\"" ?> /><?php _e( "Hide", "jtpp-share-buttons" ); ?>
</div>
<h3><?php _e( "After the content", "jtpp-share-buttons" ); ?></h3>
<?php _e( "Default is \"Show\".", "jtpp-share-buttons" ); ?>
<div style="padding:1em 0;">
<input type="radio" name="jtpp_share_buttons[show_after_single]" value="show"<?php if( $show_after_single != "hide" ) echo " checked=\"checked\"" ?> /><?php _e( "Show", "jtpp-share-buttons" ); ?>
<input type="radio" name="jtpp_share_buttons[show_after_single]" value="hide"<?php if( $show_after_single == "hide" ) echo " checked=\"checked\"" ?> /><?php _e( "Hide", "jtpp-share-buttons" ); ?>
</div>
<h2><?php _e( "Single pages", "jtpp-share-buttons" ); ?></h2>
<p>
<?php _e( "Please select \"Show\" or \"Hide\" about share-buttons in single pages.", "jtpp-share-buttons" ); ?>
</p>
<h3><?php _e( "Before the content", "jtpp-share-buttons" ); ?></h3>
<?php _e( "Default is \"Hide\".", "jtpp-share-buttons" ); ?>
<div style="padding:1em 0;">
<input type="radio" name="jtpp_share_buttons[show_before_page]" value="show"<?php if( $show_before_page == "show" ) echo " checked=\"checked\"" ?> /><?php _e( "Show", "jtpp-share-buttons" ); ?>
<input type="radio" name="jtpp_share_buttons[show_before_page]" value="hide"<?php if( $show_before_page != "show" ) echo " checked=\"checked\"" ?> /><?php _e( "Hide", "jtpp-share-buttons" ); ?>
</div>
<h3><?php _e( "After the content", "jtpp-share-buttons" ); ?></h3>
<?php _e( "Default is \"Hide\".", "jtpp-share-buttons" ); ?>
<div style="padding:1em 0;">
<input type="radio" name="jtpp_share_buttons[show_after_page]" value="show"<?php if( $show_after_page == "show" ) echo " checked=\"checked\"" ?> /><?php _e( "Show", "jtpp-share-buttons" ); ?>
<input type="radio" name="jtpp_share_buttons[show_after_page]" value="hide"<?php if( $show_after_page != "show" ) echo " checked=\"checked\"" ?> /><?php _e( "Hide", "jtpp-share-buttons" ); ?>
</div>
<h2><?php _e( "Design", "jtpp-share-buttons" ); ?></h2>
<p>
<?php _e( "Please select share-buttons' design.", "jtpp-share-buttons" ); ?>
</p>
<div style="padding:1em 0;">
<select name="jtpp_share_buttons[select_design]">
<option value="01"<?php if( $select_design == "01" || $select_design == "" ) echo " selected"; ?>><?php _e( "01", "jtpp-share-buttons" ); ?></option>
<option value="02"<?php if( $select_design == "02" ) echo " selected"; ?>><?php _e( "02", "jtpp-share-buttons" ); ?></option>
</select>
</div>
</div>
<?php submit_button(); ?>
</form>
<?php
    }
}

// Run only in the management screen.
if( !function_exists( 'wp_get_current_user' ) ) {
    include( ABSPATH . "wp-includes/pluggable.php" ); 
}
if( current_user_can( 'manage_options' ) ) {
    $jtpp_share_buttoons = new jtpp_share_buttons();
}
