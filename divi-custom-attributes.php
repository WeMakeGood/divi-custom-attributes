<?php
/**
 * Plugin Name: Divi Custom Attributes
 * Description: Add custom HTML attributes to any Divi module
 * Version: 1.0.0
 * Author: Christopher Frazier <chris.frazier@wemakegood.org>
 * Author URI: https://wemakegood.org
 * Plugin URI: https://github.com/WeMakeGood/divi-custom-attributes
 * Text Domain: divi-custom-attributes
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.3
 * Requires PHP: 7.2
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DIVI_CUSTOM_ATTRIBUTES_VERSION', '1.0.0');
define('DIVI_CUSTOM_ATTRIBUTES_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DIVI_CUSTOM_ATTRIBUTES_PLUGIN_URL', plugin_dir_url(__FILE__));

// Check if Divi is active
function divi_custom_attributes_check_divi() {
    if (!function_exists('et_get_theme_version')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo __('Divi Custom Attributes requires the Divi theme or Divi Builder plugin to be active.', 'divi-custom-attributes');
            echo '</p></div>';
        });
        return false;
    }
    return true;
}

// Initialize plugin
function divi_custom_attributes_init() {
    if (!divi_custom_attributes_check_divi()) {
        return;
    }
    
    // Load plugin textdomain
    load_plugin_textdomain('divi-custom-attributes', false, dirname(plugin_basename(__FILE__)) . '/languages');
    
    // Include required files
    require_once DIVI_CUSTOM_ATTRIBUTES_PLUGIN_DIR . 'includes/class-divi-custom-attributes.php';
    
    // Initialize main plugin class
    Divi_Custom_Attributes::get_instance();
}

// Hook into plugins_loaded to ensure all dependencies are loaded
add_action('plugins_loaded', 'divi_custom_attributes_init');

// Activation hook
register_activation_hook(__FILE__, function() {
    if (!divi_custom_attributes_check_divi()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(__('Divi Custom Attributes requires the Divi theme or Divi Builder plugin to be active.', 'divi-custom-attributes'));
    }
});