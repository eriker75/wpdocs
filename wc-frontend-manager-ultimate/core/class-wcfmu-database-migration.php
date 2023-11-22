<?php
/**
 * WCFMu plugin core
 *
 * Plugin Database Migration Controler
 *
 * @author  WC Lovers
 * @package wcfmu/core
 * @version 6.7.0
 */

class WCFMu_Database_Migration_Helper {
	/**
	 * Loads the class, runs on init.
	 */
	public function __construct() {
		add_action('admin_notices', array($this, 'wcfmu_db_update_admin_notice'));
		add_action('admin_init', array($this, 'install_actions'));
		add_action('vendor_migration_cron_hook', array($this, 'all_store_address_migration'));
	}

	/**
	 *  Add a notice to WP-Admin to update WCFM database
	 */
	public function wcfmu_db_update_admin_notice() {
		$is_ultimate_gte_6_7_0 = defined('WCFMu_VERSION') && version_compare(WCFMu_VERSION, '6.7.0', '>=');
		if ($is_ultimate_gte_6_7_0 && get_option('wcfmmp_db_version') == '' && current_user_can('administrator')) {
			$update_url = wp_nonce_url(
				add_query_arg('do_update_wcfmmp', 'true', admin_url('admin.php?page=wcfm_settings')),
				'wcfmmp_db_update',
				'wcfmmp_db_update_nonce'
			);
			?>
			<div id="message" class="updated notice error">
				<p>
					<strong><?php esc_html_e('WCFM database update required', 'wc-frontend-manager-ultimate'); ?></strong>
				</p>
				<p>
					<?php esc_html_e('WCFM - Ultimate has been updated! To keep things running smoothly, we have to update your database to the newest version. The database update process runs in the background and may take a little while, so please be patient.', 'wc-frontend-manager-ultimate'); ?>
				</p>
				<p class="submit">
					<a href="<?php echo esc_url($update_url); ?>" class="wc-update-now button-primary">
						<?php esc_html_e('Update WCFM Database', 'wc-frontend-manager-ultimate'); ?>
					</a>
					<a href="https://wclovers.com/wcfm-ultimate-changelog/" class="button-secondary">
						<?php esc_html_e('Learn more about updates', 'wc-frontend-manager-ultimate'); ?>
					</a>
				</p>
			</div>
			<?php
		}
	}

	/**
	 *  Check plugin needs to update for migrate database
	 */
	public function wcfmu_plugin_check_update() {
		$vendor_count = count(get_users(array('fields' => array('ID'), 'role' => 'wcfm_vendor')));
		update_option('wcfm_store_count', $vendor_count);
		$this->update();
		update_option('wcfmmp_db_version', '1.0');
	}

	/**
	 *  sync user location table initiate cron
	 */
	public function update() {
		store_multi_location_db_create();

		if (class_exists('WooCommerce')) {

			$next = WC()->queue()->get_next('vendor_migration_cron_hook');
			if (!$next) {
				WC()->queue()->schedule_single(time(), 'vendor_migration_cron_hook', array('offset' => 0));
			}
		}
	}

	/**
	 *  notice submit action
	 */
	public function install_actions() {
		if (!empty($_GET['do_update_wcfmmp'])) { // WPCS: input var ok.
			check_admin_referer('wcfmmp_db_update', 'wcfmmp_db_update_nonce');
			$this->update();
			update_option('wcfmmp_db_version', '1.0');
		}
	}

	/**
	 *  action scheduler
	 */
	public function all_store_address_migration($offset) {
		global $wpdb;

		$table_name = "{$wpdb->prefix}wcfm_store_locations";
		$limit = 20;
		$role = 'wcfm_vendor'; // Replace this with the desired user role
		$query = "SELECT $wpdb->users.ID FROM $wpdb->users
	            INNER JOIN $wpdb->usermeta ON ($wpdb->users.ID = $wpdb->usermeta.user_id)
	            WHERE $wpdb->usermeta.meta_key = '{$wpdb->prefix}capabilities'
	            AND $wpdb->usermeta.meta_value LIKE '%\"{$role}\"%'
	            LIMIT $limit OFFSET $offset";
		$users = $wpdb->get_results($query);

		if ($users) {
			foreach ($users as $vendor) {
				$store_id = $vendor->ID;

				$profile_settings = get_user_meta($store_id, 'wcfmmp_profile_settings', true);
				if (!empty($profile_settings['geolocation']) && get_user_meta($store_id, 'store_hv_multiloc', true) == '') {

					$store_lat = $profile_settings['geolocation']['store_lat'];
					$store_lng = $profile_settings['geolocation']['store_lng'];
					$map_address = $profile_settings['geolocation']['store_location'];
					$add1 = $profile_settings['address']['street_1'];
					$add2 = $profile_settings['address']['street_2'];
					$city = $profile_settings['address']['city'];
					$postal_code = $profile_settings['address']['zip'];
					$state = $profile_settings['address']['state'];
					$country = $profile_settings['address']['country'];

					$result = $wpdb->insert(
						$table_name,
						array(
							'store_id' => $store_id,
							'latitude'   => $store_lat,
							'longitude' => $store_lng,
							'map_address' => $map_address,
							'address' => $add1,
							'address2' => $add2,
							'city' => $city,
							'postal_code' => $postal_code,
							'state' => $state,
							'country' => $country,
						),
						array(
							'%d',
							'%f',
							'%f',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
						)
					);
					
					if (!$result) {
						return new WP_Error('method-not-added', __('Unable to add store location', 'wc-frontend-manager-ultimate'));
					}

					$location_meta_tbl = "{$wpdb->prefix}wcfm_store_locations_meta";

					$data = [
						[
							'branch_id' 	=> $wpdb->insert_id,
							'store_id'   	=> $store_id,
							'meta_key' 		=> 'is_main_branch',
							'meta_value' 	=> 1,
						],
						[
							'branch_id'		=> $wpdb->insert_id,
							'store_id'  	=> $store_id,
							'meta_key' 		=> 'offers_pickup',
							'meta_value' 	=> 1,
						],
						[
							'branch_id' 	=> $wpdb->insert_id,
							'store_id'   	=> $store_id,
							'meta_key' 		=> 'offers_shipping',
							'meta_value' 	=> 1,
						],
					];

					foreach( $data as $row ) {
						$inserted = $wpdb->insert(
							$location_meta_tbl,
							$row,
							[ '%d', '%d', '%s', '%s' ]
						);
						
						if (!$inserted) {
							return new WP_Error('method-not-added', __('Unable to add store location meta', 'wc-frontend-manager-ultimate'));
						}
					}

					update_user_meta($store_id, 'store_hv_multiloc', 1);
				}
			}

			if ($offset >= get_option('wcfm_store_count')) {
				WC()->queue()->cancel_all('vendor_migration_cron_hook');
			} else {
				// Schedule the next iteration of the cron job
				$next_offset =  $offset + $limit;
				update_option('data_migration_offset', $next_offset);
				WC()->queue()->schedule_single(time(), 'vendor_migration_cron_hook', array('offset' => $next_offset));
			}
		}
	}
} //end class
