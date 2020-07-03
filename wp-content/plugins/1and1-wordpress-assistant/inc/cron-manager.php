<?php
// Do not allow direct access!
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class One_And_One_Cron_Manager {

	/**
	 * One_And_One_Cron_Update_Plugin_Meta constructor.
	 * (Set up cronjob only in Managed mode)
	 */
	public function __construct() {

		if ( oneandone_is_managed() ) {
			add_action( 'login_form', array( $this, 'setup_schedule' ) );
			add_action( 'oneandone_cron_update_meta_cache',
				array( $this, 'update_meta_cache' ) );
			add_action( 'oneandone_cron_cleanup_expired_transients',
				array( $this, 'cleanup_expired_transients' ) );
		}
	}

	public function setup_schedule() {
		if ( ! wp_next_scheduled( 'oneandone_cron_update_meta_cache' ) ) {
			wp_schedule_event( time(), 'daily',
				'oneandone_cron_update_meta_cache' );
		}
		if ( ! wp_next_scheduled( 'oneandone_cron_cleanup_expired_transients' ) ) {
			wp_schedule_event( time(), 'daily',
				'oneandone_cron_cleanup_expired_transients' );
		}
	}

	public function update_meta_cache() {
		include_once 'cache-manager.php';
		include_once 'sitetype-filter.php';

		$cache_manager    = new One_And_One_Assistant_Cache_Manager();
		$site_type_filter = new One_And_One_Assistant_Sitetype_Filter();

		$cache_manager->fill_cache( $site_type_filter );
	}

	public function cleanup_expired_transients() {
		global $wpdb;

		$table = $wpdb->options;
		$time  = time();

		// select all expired transients in wp_options
		$expired_transients = $wpdb->get_col(
			"
				SELECT option_name
				FROM $table
				WHERE option_name LIKE '%_transient_timeout_%'
				AND option_value < $time
				"
		);

		//delete all selected transients
		if ( ! empty( $expired_transients ) ) {
			foreach ( $expired_transients as $key => $value ) {
				if ( strpos( $value, '_site_' ) === 0 ) {
					$transient = str_replace( '_site_transient_timeout_', '', $value );
					delete_site_transient( $transient );
				} else {
					$transient = str_replace( '_transient_timeout_', '', $value );
					delete_transient( $transient );
				}
			}
		}
	}
}

new One_And_One_Cron_Manager();
