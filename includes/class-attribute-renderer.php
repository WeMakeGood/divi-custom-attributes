<?php
/**
 * Attribute Renderer Class
 *
 * @package DiviCustomAttributes
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Divi_Custom_Attributes_Attribute_Renderer {
    
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
        add_filter('et_module_shortcode_output', array($this, 'add_custom_attributes_to_output'), 10, 3);
    }
    
    public function add_custom_attributes_to_output($output, $render_slug, $module) {
        // Get custom attributes from module props
        $custom_attributes = isset($module->props['custom_attributes']) ? $module->props['custom_attributes'] : '[]';
        
        // Decode JSON
        $attributes = json_decode($custom_attributes, true);
        
        // Return original output if no attributes or invalid JSON
        if (empty($attributes) || !is_array($attributes)) {
            return $output;
        }
        
        // Build attributes string
        $attributes_string = $this->build_attributes_string($attributes);
        
        // Add attributes to the module's root element
        if (!empty($attributes_string)) {
            $output = $this->inject_attributes_into_output($output, $attributes_string);
        }
        
        return $output;
    }
    
    private function build_attributes_string($attributes) {
        $attributes_array = array();
        
        foreach ($attributes as $attribute) {
            if (empty($attribute['key']) || !isset($attribute['value'])) {
                continue;
            }
            
            $key = $this->sanitize_attribute_key($attribute['key']);
            $value = $this->sanitize_attribute_value($attribute['value']);
            
            if ($key && $value !== null) {
                $attributes_array[] = sprintf('%s="%s"', $key, $value);
            }
        }
        
        return implode(' ', $attributes_array);
    }
    
    private function sanitize_attribute_key($key) {
        // Remove any dangerous characters and validate attribute name
        $key = trim($key);
        
        // Only allow alphanumeric characters, hyphens, and underscores
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_-]*$/', $key)) {
            return false;
        }
        
        // Prevent dangerous attributes
        $forbidden_attributes = array(
            'onclick', 'onload', 'onerror', 'onmouseover', 'onmouseout',
            'onfocus', 'onblur', 'onchange', 'onsubmit', 'onreset',
            'onselect', 'onkeydown', 'onkeyup', 'onkeypress',
            'javascript', 'vbscript', 'expression'
        );
        
        if (in_array(strtolower($key), $forbidden_attributes)) {
            return false;
        }
        
        return esc_attr($key);
    }
    
    private function sanitize_attribute_value($value) {
        // Basic sanitization for attribute values
        return esc_attr(trim($value));
    }
    
    private function inject_attributes_into_output($output, $attributes_string) {
        // Find the first opening tag in the output
        if (preg_match('/<([a-zA-Z][a-zA-Z0-9]*)(.*?)>/', $output, $matches, PREG_OFFSET_CAPTURE)) {
            $tag_name = $matches[1][0];
            $existing_attributes = $matches[2][0];
            $tag_start = $matches[0][1];
            $tag_end = $tag_start + strlen($matches[0][0]);
            
            // Build new opening tag with custom attributes
            $new_tag = '<' . $tag_name . $existing_attributes . ' ' . $attributes_string . '>';
            
            // Replace the original opening tag with the new one
            $output = substr_replace($output, $new_tag, $tag_start, $tag_end - $tag_start);
        }
        
        return $output;
    }
}