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
    // Ensure plugin functions are available
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    
    // Check for Divi theme
    $theme = wp_get_theme();
    $is_divi_theme = ($theme->get('Name') === 'Divi' || $theme->get('Template') === 'Divi');
    
    // Check for Divi Builder plugin
    $is_divi_builder_active = function_exists('is_plugin_active') && is_plugin_active('divi-builder/divi-builder.php');
    
    // Check for common Divi functions (loaded after theme/plugins are loaded)
    $has_divi_functions = function_exists('et_get_theme_version') || 
                         function_exists('et_core_is_fb_enabled') || 
                         function_exists('et_pb_is_pagebuilder_used') ||
                         defined('ET_BUILDER_VERSION') ||
                         defined('ET_BUILDER_THEME');
    
    // Check if we're in admin and Divi functions might not be loaded yet
    if (is_admin() && $is_divi_theme) {
        return true; // If Divi theme is active, assume it's OK in admin
    }
    
    if (!$is_divi_theme && !$is_divi_builder_active && !$has_divi_functions) {
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

// Activation hook - use a more lenient check during activation
register_activation_hook(__FILE__, function() {
    // During activation, just check if Divi theme is active since functions might not be loaded yet
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    
    $theme = wp_get_theme();
    $is_divi_theme = ($theme->get('Name') === 'Divi' || $theme->get('Template') === 'Divi');
    $is_divi_builder_active = function_exists('is_plugin_active') && is_plugin_active('divi-builder/divi-builder.php');
    
    if (!$is_divi_theme && !$is_divi_builder_active) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(__('Divi Custom Attributes requires the Divi theme or Divi Builder plugin to be active.', 'divi-custom-attributes'));
    }
});