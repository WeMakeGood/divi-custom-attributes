<?php
/**
 * Main Plugin Class
 *
 * @package DiviCustomAttributes
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Divi_Custom_Attributes {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
        $this->load_dependencies();
    }
    
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    private function load_dependencies() {
        require_once DIVI_CUSTOM_ATTRIBUTES_PLUGIN_DIR . 'includes/class-module-extension.php';
        require_once DIVI_CUSTOM_ATTRIBUTES_PLUGIN_DIR . 'includes/class-attribute-renderer.php';
    }
    
    public function init() {
        // Initialize module extension
        Divi_Custom_Attributes_Module_Extension::get_instance();
        
        // Initialize attribute renderer
        Divi_Custom_Attributes_Attribute_Renderer::get_instance();
    }
    
    public function enqueue_frontend_scripts() {
        // Only enqueue on pages with Divi Builder content
        if (et_core_is_fb_enabled() || et_pb_is_pagebuilder_used(get_the_ID())) {
            wp_enqueue_style(
                'divi-custom-attributes-frontend',
                DIVI_CUSTOM_ATTRIBUTES_PLUGIN_URL . 'assets/css/frontend.css',
                array(),
                DIVI_CUSTOM_ATTRIBUTES_VERSION
            );
        }
    }
    
    public function enqueue_admin_scripts($hook) {
        // Only enqueue on Divi Builder pages
        if (et_core_is_fb_enabled() || (isset($_GET['et_fb']) && $_GET['et_fb'] === '1')) {
            wp_enqueue_script(
                'divi-custom-attributes-admin',
                DIVI_CUSTOM_ATTRIBUTES_PLUGIN_URL . 'assets/js/admin-interface.js',
                array('jquery'),
                DIVI_CUSTOM_ATTRIBUTES_VERSION,
                true
            );
            
            wp_enqueue_style(
                'divi-custom-attributes-admin',
                DIVI_CUSTOM_ATTRIBUTES_PLUGIN_URL . 'assets/css/admin-styles.css',
                array(),
                DIVI_CUSTOM_ATTRIBUTES_VERSION
            );
            
            wp_localize_script(
                'divi-custom-attributes-admin',
                'DiviCustomAttributesAdmin',
                array(
                    'nonce' => wp_create_nonce('divi_custom_attributes_nonce'),
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'strings' => array(
                        'add_attribute' => __('Add Attribute', 'divi-custom-attributes'),
                        'attribute_name' => __('Attribute Name', 'divi-custom-attributes'),
                        'attribute_value' => __('Attribute Value', 'divi-custom-attributes'),
                        'remove_attribute' => __('Remove Attribute', 'divi-custom-attributes'),
                        'custom_attributes' => __('Custom Attributes', 'divi-custom-attributes'),
                        'help_text' => __('Add custom HTML attributes to this module. These will be added to the module\'s root element.', 'divi-custom-attributes')
                    )
                )
            );
        }
    }
}