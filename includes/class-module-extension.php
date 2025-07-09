<?php
/**
 * Module Extension Class
 *
 * @package DiviCustomAttributes
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Divi_Custom_Attributes_Module_Extension {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        add_action('et_builder_ready', array($this, 'add_custom_fields'));
        add_filter('et_pb_module_shortcode_attributes', array($this, 'add_attributes_to_shortcode'), 10, 5);
        add_action('et_builder_ready', array($this, 'add_custom_toggles'));
    }
    
    public function add_custom_fields() {
        // Get all registered modules
        $modules = ET_Builder_Element::get_modules();
        
        foreach ($modules as $module_slug => $module) {
            add_filter("et_pb_all_fields_unprocessed_{$module_slug}", array($this, 'add_custom_attributes_field'));
        }
    }
    
    public function add_custom_toggles() {
        // Add custom toggle to Advanced tab for all modules
        $modules = ET_Builder_Element::get_modules();
        
        foreach ($modules as $module_slug => $module) {
            add_filter("et_pb_module_advanced_fields_{$module_slug}", array($this, 'add_custom_attributes_toggle'));
        }
    }
    
    public function add_custom_attributes_toggle($advanced_fields) {
        $advanced_fields['custom_attributes'] = array(
            'label' => __('Custom Attributes', 'divi-custom-attributes'),
            'toggle_slug' => 'custom_attributes',
            'description' => __('Add custom HTML attributes to this module.', 'divi-custom-attributes'),
        );
        
        return $advanced_fields;
    }

    public function add_custom_attributes_field($fields) {
        // First add the toggle to the Advanced tab
        if (!isset($fields['advanced_tab']['toggles']['custom_attributes'])) {
            $fields['advanced_tab']['toggles']['custom_attributes'] = array(
                'title' => __('Custom Attributes', 'divi-custom-attributes'),
                'priority' => 100,
            );
        }
        
        // Add the actual field using textarea type (which we can customize with JS)
        $fields['custom_attributes'] = array(
            'label' => __('Custom Attributes', 'divi-custom-attributes'),
            'type' => 'textarea',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'custom_attributes',
            'description' => __('Add custom HTML attributes to this module. These will be added to the module\'s root element.', 'divi-custom-attributes'),
            'default' => '[]',
            'show_if' => array(),
            'depends_show_if' => 'off'
        );
        
        return $fields;
    }
    
    public function add_attributes_to_shortcode($props, $attrs, $render_slug, $address, $content) {
        // Ensure custom_attributes is included in the shortcode attributes
        if (!isset($props['custom_attributes'])) {
            $props['custom_attributes'] = '[]';
        }
        
        return $props;
    }
}