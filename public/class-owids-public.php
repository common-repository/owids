<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       owids.com
 * @since      1.0.0
 *
 * @package    Owids
 * @subpackage Owids/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Owids
 * @subpackage Owids/public
 * @author     Owids <touch@owids.com>
 */
class Owids_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the snippet for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function add_snippet() {

		$data = get_option( Owids_Constant::APP_SETTINGS_KEY );
		$data = json_decode( $data, true );
		if ( isset( $data['api_key'] ) && $data['api_key'] ) {
			$api_key = $data['api_key'];
			include_once plugin_dir_path( __FILE__ ) . 'partials/owids-public-snippet.php';
		}

	}

}
