<?php
/**
 * WCFMapi Dependency Checker
 *
 */
class WCFMapi_Dependencies {
	
	private static $active_plugins;
	
	static function init() {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() )
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}
  
  // wc-multivendor-marketplace active check
	static function wcfmapi_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'wc-multivendor-marketplace/wc-multivendor-marketplace.php', self::$active_plugins ) || array_key_exists( 'wc-multivendor-marketplace/wc-multivendor-marketplace.php', self::$active_plugins );
		return false;
	}

	// wc-multivendor-ultimate active check
	static function wcfmapi_ultimate_plugin_active_check() {
		if ( ! self::$active_plugins ) self::init();
		return in_array( 'wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php', self::$active_plugins ) || array_key_exists( 'wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php', self::$active_plugins );
		return false;
	}
  
}