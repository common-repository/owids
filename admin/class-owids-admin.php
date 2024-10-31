<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       owids.com
 * @since      1.0.0
 *
 * @package    Owids
 * @subpackage Owids/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Owids
 * @subpackage Owids/admin
 * @author     Owids <touch@owids.com>
 */
class Owids_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Save plugin api key callback.
	 *
	 * @since    1.0.0
	 */
	public function save_api_key_callback()
	{
			$api_key = isset( $_POST['api_key'] ) ? sanitize_text_field( $_POST['api_key'] ) : '';
			if ( !$api_key ) {
					wp_send_json_error();
					wp_die();
			}

			$current_settings = get_option( Owids_Constant::APP_SETTINGS_KEY );
			$current_settings = json_decode( $current_settings, true );
			$current_settings['api_key'] = $api_key;


			// Save plugin settings
			update_option( Owids_Constant::APP_SETTINGS_KEY, wp_json_encode( $current_settings ) );

			wp_send_json_success(true, 200);
			wp_die();
	}

	/**
	 * Register the plugin links for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_links( $links ) {
		
		$more_links = array();
		$more_links['settings'] = '<a href="' . admin_url( 'options-general.php?page=owids' ) . '">' . __( 'Settings', 'owids' ) . '</a>';

		return array_merge( $more_links, $links );
						
	}

	/**
	 * Register the plugin menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_menu() {

		add_submenu_page(
			'options-general.php',
			__( 'Owids - 10+ Widgets', 'owids' ),
			__( 'Owids', 'owids' ),
			'manage_options',
			'owids',
			array( $this, 'menu_display' )
		);

	}

	/**
	 * Plugin menu display content for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function menu_display() {

		include('partials/owids-admin-display.php');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Owids_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Owids_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Load only on plugin page
		if ( $hook !== 'settings_page_owids' ) {
			return;
		}

		$app_name = 'app';
		if ( OWIDS_ENV === 'production' ) {
			$app_name = 'app.min';
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/js/' . $app_name. '.js', array(), $this->version, true );

		// Add vars to plugin
		$data = get_option( Owids_Constant::APP_SETTINGS_KEY );
		$data = json_decode( $data, true );
		wp_localize_script( $this->plugin_name, 'owids_vars', array(
				'data' => $data ? $data : [],
		));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Owids_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Owids_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Load only on plugin page
		if ( $hook !== 'settings_page_owids' || OWIDS_ENV !== 'production' ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/css/app.min.css', array(), $this->version, 'all' );

	}

}
