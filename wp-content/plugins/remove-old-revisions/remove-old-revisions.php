<?php
/**
 * Plugin Name:	Remove Old Revisions
 * Description:	This plugin is able to automatically remove revisions older than n days.
 * Version:		1.0.3
 * Author:		HerrLlama for wpcoding.de
 * Author URI:	http://wpcoding.de
 * Licence:		GPLv3
 */

// check wp
if ( ! function_exists( 'add_action' ) )
	return;

/**
 * This function inits the plugin, registers the cron
 * and loads the settings
 *
 * @wp-hook	plugins_loaded
 * @return	void
 */
function ror_init() {

	// register the cron job
	add_action( 'ror_check_and_remove_revisions', 'ror_check_and_remove_revisions' );
	if ( ! wp_next_scheduled( 'ror_check_and_remove_revisions' ) )
		wp_schedule_event( current_time( 'timestamp' ), 'daily', 'ror_check_and_remove_revisions');

	// we only need this in admin area
	if ( ! is_admin() )
		return;

	// localization
	load_plugin_textdomain( 'remove-revisions-td', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	// add settings section
	add_action( 'admin_init', 'ror_add_settings_field' );
} add_action( 'plugins_loaded', 'ror_init' );

/**
 * the wp-cronjob which checks for old revisions
 *
 * @retun	void
 */
function ror_check_and_remove_revisions() {

	if ( 0 == get_option( 'ror_input', 0 ) )
		return;

	// we need to add the post_date check manually
	// due to not providing this in the WP core
	add_filter( 'posts_where', 'ror_set_revisions_date_range' );
	$revisions = new WP_Query( array(
		'post_status'		=> 'inherit',
		'post_type'			=> 'revision',
		'showposts'			=> -1,
		'posts_per_page'	=> -1
	) );
	remove_filter( 'posts_where', 'ror_set_revisions_date_range' );

	if ( $revisions->have_posts() ) {
		global $wpdb;
		foreach ( $revisions->posts as $revision ) {
			$query = $wpdb->prepare( 'DELETE FROM ' . $wpdb->posts . ' WHERE ID = %d', $revision->ID );
			$wpdb->query( $query );
		}
	}
}

/**
 * Adds the date range to a query
 *
 * @todo	change this to date_query
 *
 * @wp-hook	posts_where
 * @param	string $where the current where string
 * @return	string the manipulated where string
 */
function ror_set_revisions_date_range( $where = '' ) {
	global $wpdb;
	$where = $where . $wpdb->prepare( ' AND post_date <= date_sub( now() , INTERVAL %d DAY )', get_option( 'ror_input' ) );
	return $where;
}

/**
 * Adds settings field to writing options panel
 *
 * @wp-hook	admin_init
 * @return	void
 */
function ror_add_settings_field() {
	add_settings_section( 'ror_input_section', __( 'Remove Revions', 'remove-revisions-td' ), 'ror_settings_section_intro', 'writing' );
	add_settings_field( 'ror_input', __( 'Remove Revions after', 'remove-revisions-td' ), 'ror_render_settings_field', 'writing', 'ror_input_section' );
	register_setting( 'writing', 'ror_input' );
}

/**
 * Displays description for the settings
 *
 * @return	void
 */
function ror_settings_section_intro() {
	?><span class="description"><?php _e( 'This setting removes the revisions which are older than the given days. Leave blank or 0 to disable the old revision check.', 'remove-revisions-td' ); ?></span><?php
}

/**
 * Displays the input boxes for the settings
 *
 * @return	void
 */
function ror_render_settings_field() {
	?><input id="ror_input" name="ror_input" class="small-text" type="number" min="0" step="1" value="<?php echo get_option( 'ror_input' ); ?>" /> <span><?php _e( 'Days', 'remove-revisions-td' ); ?></p><?php
}