# Divi Custom Attributes Plugin Development Instructions

## Project Overview

Create a WordPress plugin that extends Divi Builder modules by allowing users to add custom HTML attributes (key-value pairs) to any module. These attributes will be added through the module's Advanced tab interface and rendered on the frontend as HTML attributes on the module's root DOM element.

## Plugin Requirements

### Core Functionality

1. **Module Extension**: Hook into all Divi modules to add a custom attributes interface
2. **User Interface**: Create an intuitive UI in the Advanced tab for managing attributes
3. **Frontend Rendering**: Ensure all custom attributes are properly rendered as HTML attributes on the module's root element
4. **Data Storage**: Properly save and retrieve attribute data within Divi's module settings

### Technical Specifications

#### Plugin Structure
```
divi-custom-attributes/
├── divi-custom-attributes.php (main plugin file)
├── includes/
│   ├── class-divi-custom-attributes.php
│   ├── class-module-extension.php
│   └── class-attribute-renderer.php
├── assets/
│   ├── js/
│   │   └── admin-interface.js
│   └── css/
│       └── admin-styles.css
└── readme.txt
```

#### Key Components

1. **Main Plugin Class** (`class-divi-custom-attributes.php`)
   - Initialize the plugin and load dependencies
   - Hook into Divi Builder's module system
   - Register scripts and styles for the admin interface

2. **Module Extension** (`class-module-extension.php`)
   - Extend `ET_Builder_Module` to add custom fields
   - Add the attributes interface to the Advanced tab of all modules
   - Handle saving and retrieving attribute data

3. **Attribute Renderer** (`class-attribute-renderer.php`)
   - Hook into Divi's frontend rendering process
   - Parse saved attributes and add them to the module's HTML output
   - Ensure proper escaping and security measures

4. **Admin Interface** (`admin-interface.js`)
   - Create dynamic interface for adding/removing attributes
   - Handle user interactions (add button, delete buttons)
   - Validate input and update module settings

## Implementation Details

### 1. Plugin Initialization

Create the main plugin file with proper WordPress headers and initialization:

```php
/**
 * Plugin Name: Divi Custom Attributes
 * Description: Add custom HTML attributes to any Divi module
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: divi-custom-attributes
 */
```

### 2. Module Extension Implementation

The module extension should:
- Use Divi's `et_pb_all_fields_unprocessed_{$slug}` filter to add custom fields
- Add a repeater-style field group for attributes under the Advanced tab
- Each attribute entry should have:
  - Text input for attribute name (key)
  - Text input for attribute value
  - Delete button to remove the attribute

### 3. User Interface Requirements

The interface should include:
- A section titled "Custom Attributes" in the Advanced tab
- An "Add Attribute" button with a plus (+) icon
- Dynamic rows for each attribute with:
  - Label "Attribute Name" for the key field
  - Label "Attribute Value" for the value field
  - A remove/delete icon for each row
- Proper styling to match Divi's interface design

### 4. Frontend Rendering

The renderer should:
- Hook into `et_module_shortcode_output` filter
- Parse the module's custom attributes data
- Add attributes to the module's opening HTML tag
- Handle special cases:
  - Data attributes (data-*)
  - ARIA attributes (aria-*)
  - Custom attributes
- Ensure proper HTML escaping using WordPress functions

### 5. Data Structure

Store attributes as a serialized array in the module settings:
```php
[
    [
        'key' => 'data-custom',
        'value' => 'example-value'
    ],
    [
        'key' => 'aria-label',
        'value' => 'Custom label'
    ]
]
```

## Security Considerations

1. **Input Validation**: Validate attribute names to prevent XSS attacks
2. **Output Escaping**: Use `esc_attr()` for all attribute values
3. **Capability Checks**: Ensure only authorized users can modify attributes
4. **Nonce Verification**: Implement proper nonce verification for AJAX requests

## Compatibility Requirements

1. **Divi Version**: Compatible with Divi 4.0 and above
2. **WordPress Version**: Compatible with WordPress 5.0 and above
3. **PHP Version**: Require PHP 7.2 or higher
4. **Browser Support**: Modern browsers (Chrome, Firefox, Safari, Edge)

## Testing Checklist

1. **Functionality Tests**
   - Verify attributes can be added to all Divi module types
   - Test adding multiple attributes to a single module
   - Verify attributes appear correctly on the frontend
   - Test attribute deletion functionality
   - Ensure attributes persist after saving and page reload

2. **Edge Cases**
   - Test with special characters in attribute names and values
   - Verify behavior with empty attribute names or values
   - Test with very long attribute names and values
   - Ensure proper handling of duplicate attribute names

3. **Performance Tests**
   - Verify no significant impact on page load time
   - Test with modules containing many attributes (10+)
   - Ensure efficient database queries

## User Documentation

Include inline help text in the interface:
- "Add custom HTML attributes to this module. These will be added to the module's root element."
- Tooltip for attribute name: "Enter the attribute name (e.g., data-custom, aria-label)"
- Tooltip for attribute value: "Enter the attribute value"

## Error Handling

1. Display user-friendly error messages for:
   - Invalid attribute names
   - Failed save operations
   - Network errors during AJAX requests

2. Implement fallback behavior if Divi is not active

## Future Enhancements (Optional)

Consider these features for future versions:
1. Attribute templates for common use cases
2. Import/export functionality for attribute sets
3. Global attributes that can be applied to multiple modules
4. Conditional attributes based on device type or user role

## Development Notes

- Use WordPress coding standards throughout
- Implement proper internationalization using the plugin's text domain
- Add inline documentation for all functions and classes
- Create a comprehensive readme.txt file for the WordPress repository
- Consider adding unit tests for critical functionality

This plugin should provide a simple, intuitive way for Divi users to add custom attributes to their modules without requiring code modifications or child theme development.