=== Divi Custom Attributes ===
Contributors: christopherfrazier, wemakegood
Tags: divi, attributes, html, custom, builder
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add custom HTML attributes to any Divi Builder module through an intuitive interface in the Advanced tab.

== Description ==

Divi Custom Attributes is a powerful WordPress plugin that extends the functionality of Divi Builder by allowing you to add custom HTML attributes to any Divi module. This plugin provides a user-friendly interface in the Advanced tab of each module, making it easy to add data attributes, ARIA labels, custom classes, and other HTML attributes without touching code.

= Key Features =

* **Easy Interface**: Simple, intuitive interface in the Advanced tab of all Divi modules
* **Add/Remove Attributes**: Dynamically add or remove custom attributes with a click
* **Secure**: Built-in security measures to prevent XSS attacks and malicious code
* **Compatible**: Works with all Divi modules and themes
* **Frontend Rendering**: Attributes are properly rendered on the frontend
* **No Code Required**: Perfect for users who want to add custom attributes without editing code

= Use Cases =

* Add data attributes for JavaScript interactions
* Include ARIA labels for accessibility
* Add custom tracking attributes for analytics
* Insert microdata for SEO
* Add custom CSS classes or IDs
* Include any other valid HTML attributes

= How It Works =

1. Install and activate the plugin
2. Edit any Divi module
3. Go to the Advanced tab
4. Find the "Custom Attributes" section
5. Click "Add Attribute" to add new attributes
6. Enter the attribute name and value
7. Save the module

The attributes will be automatically added to the module's HTML output on the frontend.

== Installation ==

1. Upload the `divi-custom-attributes` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure you have Divi theme or Divi Builder plugin active
4. Start adding custom attributes to your Divi modules!

== Frequently Asked Questions ==

= Does this plugin work with the Divi theme? =

Yes, this plugin works with both the Divi theme and the Divi Builder plugin.

= Are there any security concerns with adding custom attributes? =

The plugin includes built-in security measures to prevent XSS attacks and malicious code. All attribute names and values are properly sanitized and validated.

= Can I add multiple attributes to a single module? =

Yes, you can add as many custom attributes as needed to each module.

= Will this affect my site's performance? =

No, the plugin is designed to be lightweight and only loads when the Divi Builder is active.

= Can I use this for data attributes? =

Yes, data attributes (data-*) are fully supported and commonly used with this plugin.

= Does this work with all Divi modules? =

Yes, the custom attributes functionality is added to all Divi modules automatically.

== Screenshots ==

1. Custom Attributes interface in the Advanced tab of a Divi module
2. Adding multiple attributes to a module
3. Frontend output showing custom attributes in the HTML

== Changelog ==

= 1.0.0 =
* Initial release
* Add custom attributes interface to all Divi modules
* Frontend rendering of custom attributes
* Security measures for attribute validation
* Responsive admin interface

== Upgrade Notice ==

= 1.0.0 =
Initial release of Divi Custom Attributes plugin.

== Developer Notes ==

This plugin hooks into Divi's module system using the `et_pb_all_fields_unprocessed_{$slug}` filter to add custom fields and the `et_module_shortcode_output` filter to render attributes on the frontend.

For developers who want to extend this plugin or add custom functionality:

* Main plugin class: `Divi_Custom_Attributes`
* Module extension: `Divi_Custom_Attributes_Module_Extension`
* Attribute renderer: `Divi_Custom_Attributes_Attribute_Renderer`

All classes follow WordPress coding standards and include proper security measures.