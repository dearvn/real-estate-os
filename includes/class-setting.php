<?php
/**
 * Setting class.
 *
 * @package WPRS
 */

namespace WPRS;

use WPRS\Traits\Singleton;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add styles of scripts files inside this class.
 */
class Setting {

	use Singleton;

	/**
	 * Constructor of Setting class.
	 */
	private function __construct() {

		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );

		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		add_options_page(
			__( 'Settings Admin' ),
			__( 'Real Estate Settings' ),
			'manage_options',
			'real-estate-setting-admin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option( 'real_estate_option_name' );
		?>
		<div class="wrap">
			<h1><?php echo __( 'Real Estate Settings' ); ?></h1>
			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'real_estate_option_group' );
				do_settings_sections( 'real-estate-setting-admin' );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'real_estate_option_group', // Option group
			'real_estate_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			__( 'Common Settings' ), // Title
			array( $this, 'print_section_info' ), // Callback
			'real-estate-setting-admin' // Page
		);

		add_settings_field(
			'prices',
			__( 'Price Options' ),
			array( $this, 'price_callback' ),
			'real-estate-setting-admin',
			'setting_section_id'
		);

		add_settings_field(
			'acreages',
			__( 'Acreage Options' ),
			array( $this, 'acreage_callback' ),
			'real-estate-setting-admin',
			'setting_section_id'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input['prices'] ) ) {
			$new_input['prices'] = sanitize_text_field( $input['prices'] );
		}

		if ( isset( $input['acreages'] ) ) {
			$new_input['acreages'] = sanitize_text_field( $input['acreages'] );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		print __( 'Enter your settings below:' );
	}

	/**
	 * Get the acreage settings option array and print one of its values
	 */
	public function acreage_callback() {
		printf(
			'<textarea id="acreages" rows="4" cols="40" name="real_estate_option_name[acreages]">%s</textarea>',
			isset( $this->options['acreages'] ) ? esc_attr( $this->options['acreages'] ) : ''
		);
	}

	/**
	 * Get the price settings option array and print one of its values
	 */
	public function price_callback() {
		printf(
			'<textarea id="prices" rows="4" cols="40" name="real_estate_option_name[prices]">%s</textarea>',
			isset( $this->options['prices'] ) ? esc_attr( $this->options['prices'] ) : ''
		);
	}

}
