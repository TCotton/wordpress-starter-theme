<?php
namespace startertheme\options;

/**
 * Admin_Options_Page
 *
 * @package
 * @author
 * @access public
 */
class Admin_Options_Page {

	static $page_basename = 'theme_options';
	static $options_name = 'theme_options_save';

	public function __construct() {

		add_action( 'admin_menu', array( &$this, 'options_add_page' ) );

		if ( session_id() == '' ) {
			session_start();
			session_regenerate_id( true );
		} else {
			session_regenerate_id( true );
		}

	}


	/**
	 * Admin_Options_Page::options_add_page()
	 *
	 * Create the admin theme page by calling the add_theme_hook()
	 *
	 * @return
	 */
	public function options_add_page() {

		$theme_page = add_theme_page( __( 'Theme Options' ), // Name of page
			__( 'Theme Options' ), // Label in menu
			'edit_theme_options', // Capability required
			self::$page_basename, // Menu slug, used to uniquely identify the page
			array( &$this, 'options_render_page' ) // Function that renders the options page
		);

		if ( ! $theme_page ) {
			return;
		}

		add_action( "load-$theme_page", array( &$this, 'options_help' ) );
		add_action( 'admin_init', array( &$this, 'theme_settings_options' ) );
		add_action( 'admin_notices', array( &$this, 'admin_msgs' ) );

	}


	/**
	 * Admin_Options_Page::options_render_page()
	 *
	 * Initial html form which then uses Settings API functions below
	 *
	 * @return string
	 */
	public function options_render_page() {

		echo '<div class="wrap">';
		screen_icon();
		$theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme();
		echo '<h2>';
		printf( __( '%s Theme Options' ), $theme_name );
		echo '</h2>';
		settings_errors();

		echo '<form action="options.php" method="post">';

		settings_fields( self::$options_name );
		do_settings_sections( self::$page_basename );
		submit_button();

		echo '</form></div>';

	}

	/**
	 * Admin_Options_Page::options_help()
	 *
	 * Creates initial help text
	 *
	 * @return object
	 */
	public function options_help() {

		$help = '<p>Add your Help text here</p>';

		$sidebar = '<p>Add sidebar help links if required</p>';

		$screen = get_current_screen();

		if ( method_exists( $screen, 'add_help_tab' ) ) {

			$screen->add_help_tab( array(
				'title'   => __( 'Overview' ),
				'id'      => 'theme-options-help',
				'content' => $help,
			) );

			$screen->set_help_sidebar( $sidebar );

		}

	}


	/**
	 * Admin_Options_Page::theme_settings_options()
	 *
	 * Calls Settings API wordpress hooks register_setting and add_settings_section
	 *
	 * @return wordpress hooks
	 */
	public function theme_settings_options() {

		register_setting( self::$options_name, self::$options_name, array(
			&$this,
			'theme_options_sanitize'
		) );

		add_settings_section( 'main_section', 'Main Settings', array( &$this, 'add_settings_section' ),
			self::$page_basename );

	}

	/**
	 * Admin_Options_Page::add_settings_section()
	 *
	 * Uses add_settings_field hooks
	 *
	 * @return wordpress hooks
	 */
	public function add_settings_section() {

		add_settings_field( 'text_string', 'Text Input', array( &$this, 'setting_string' ), self::$page_basename,
			'main_section' );

		add_settings_field( 'textarea_area', 'Textarea input', array( &$this, 'setting_textarea' ),
			self::$page_basename, 'main_section' );

	}


	/**
	 * Admin_Options_Page::theme_options_sanitize()
	 *
	 * Form validation and sanitization
	 *
	 * @param array $data
	 *
	 * @return array or calls wordpress hook add_settings_error
	 */
	public function theme_options_sanitize( $data ) {

		// sanitize
		$input = array_map( 'stripslashes_deep', $data );

		// for enhanced security, create a new empty array
		$valid_input = true;

		if ( ! ctype_alnum( $input['text_string'] ) ) {

			add_settings_error( 'text_string', // setting title
				'digit_error', // error ID
				__( 'Expecting a Numeric value! Please fix.' ), // error message
				'error' // type of message
			);

			// create a session for each input type
			// This is then used in the form html below otherwise all input text is wiped
			foreach ( $input as $key => $value ) {

				$_SESSION[ $key ] = $value;

			}

			$invalid_input = false;

		}


		if ( $invalid_input ) {

			// if okay then destroy all session input for each type
			foreach ( $input as $key => $value ) {

				unset( $_SESSION[ $key ] );

			}

			return $input;

		}


	}

	/**
	 * Admin_Options_Page::admin_msgs()
	 *
	 * Sets admin messages based on valid or invalid data
	 *
	 * @return calls method Admin_Options_Page::show_msg
	 */
	public function admin_msgs() {

		// check for our settings page - need this in conditional further down

		if ( isset( $_GET['page'] ) ) {
			$wptuts_settings_pg = strpos( $_GET['page'], self::$page_basename );
		}
		// collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors
		$set_errors = get_settings_errors();

		//display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!
		if ( current_user_can( 'manage_options' ) && ( isset( $wptuts_settings_pg ) && $wptuts_settings_pg
		                                                                               !== false ) && ! empty( $set_errors )
		) {

			// have our settings succesfully been updated?
			if ( $set_errors[0]['code'] == 'settings_updated' && isset( $_GET['settings-updated'] ) ) {
				$this->show_msg( "<p>" . $set_errors[0]['message'] . "</p>", 'updated' );

				// have errors been found?
			} else {
				// there maybe more than one so run a foreach loop.
				foreach ( $set_errors as $set_error ) {
					// set the title attribute to match the error "setting title" - need this in js file
					$this->show_msg( "<p class='setting-error-message' title='" . $set_error['setting'] .
					                 "'>" . $set_error['message'] . "</p>", 'error' );
				}

			}

		} // end if(current_user_can ('manage_options')

	}

	/**
	 * Admin_Options_Page::show_msg()
	 *
	 * Creates HTML error message
	 *
	 * @param string $message
	 * @param string $msgclass
	 *
	 * @return string
	 */
	public function show_msg( $message, $msgclass = 'info' ) {

		echo "<div id='message' class='$msgclass'>$message</div>";

	}


	/**
	 * Admin_Options_Page::setting_textarea()
	 *
	 * HTML for textarea
	 *
	 * @return string
	 */
	public function setting_textarea() {

		$options = get_option( self::$options_name );

		$form = '<textarea id="textarea_area" name="' . self::$options_name .
		        '[text_area]" rows="7" cols="50">';

		if ( isset( $_SESSION['text_area'] ) && $_SESSION['text_area'] != '' ) {

			$form .= esc_attr( $_SESSION['text_area'] );

		} else {

			$form .= isset( $options['text_area'] ) ? esc_attr( $options['text_area'] ) : null;

		}

		$form .= '</textarea>';

		echo $form;

	}


	/**
	 * Admin_Options_Page::setting_string()
	 *
	 * HTML for input text
	 *
	 * @return string
	 */
	public function setting_string() {

		$options = get_option( self::$options_name );

		$form = '<input id="text_string" name="' . self::$options_name .
		        '[text_string]" size="40" type="text" value="';

		if ( isset( $_SESSION['text_string'] ) && $_SESSION['text_string'] != '' ) {

			$form .= esc_attr( $_SESSION['text_string'] );

		} else {

			$form .= isset( $options['text_string'] ) ? esc_attr( $options['text_string'] ) : null;

		}

		$form .= '" />';

		echo $form;

	}

	/**
	 * Admin_Options_Page::setting_checkbox()
	 *
	 * Creates HTML for checkbox
	 *
	 * @return string
	 */
	function setting_checkbox() {

		$options = get_option( self::$options_name );
		if ( $options['chkbox1'] ) {
			$checked = ' checked="checked" ';
		}

		echo "<input " . $checked .
		     " id='plugin_chk1' name='theme_options[chkbox1]' type='checkbox' />";

	}


}

if ( is_admin() ) {

	new \startertheme\options\Admin_Options_Page();

}
