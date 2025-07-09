# Divi Custom Attributes

[![WordPress Plugin](https://img.shields.io/badge/WordPress-%E2%86%925.0-blue.svg)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-%E2%86%927.2-777BB4.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPL%20v2%2B-red.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

> Add custom HTML attributes to any Divi Builder module through an intuitive interface in the Advanced tab.

## 🎯 Overview

Divi Custom Attributes is a powerful WordPress plugin that extends the functionality of Divi Builder by allowing you to add custom HTML attributes to any Divi module. This plugin provides a user-friendly interface in the Advanced tab of each module, making it easy to add data attributes, ARIA labels, custom classes, and other HTML attributes without touching code.

## ✨ Key Features

- **🎨 Easy Interface**: Simple, intuitive interface in the Advanced tab of all Divi modules
- **➕ Add/Remove Attributes**: Dynamically add or remove custom attributes with a click
- **🔒 Secure**: Built-in security measures to prevent XSS attacks and malicious code
- **🔧 Compatible**: Works with all Divi modules and themes
- **🚀 Frontend Rendering**: Attributes are properly rendered on the frontend
- **💻 No Code Required**: Perfect for users who want to add custom attributes without editing code

## 🎪 Use Cases

- Add data attributes for JavaScript interactions
- Include ARIA labels for accessibility
- Add custom tracking attributes for analytics
- Insert microdata for SEO
- Add custom CSS classes or IDs
- Include any other valid HTML attributes

## 🚀 Installation

1. **Download or Clone**: Download the plugin or clone this repository
   ```bash
   git clone git@github.com:WeMakeGood/divi-custom-attributes.git
   ```

2. **Install**: Upload the `divi-custom-attributes` folder to your `/wp-content/plugins/` directory

3. **Activate**: Activate the plugin through the 'Plugins' menu in WordPress

4. **Requirements**: Ensure you have Divi theme or Divi Builder plugin active

5. **Start Using**: Begin adding custom attributes to your Divi modules!

## 📖 How It Works

1. **Install and activate** the plugin
2. **Edit any Divi module** in the Divi Builder
3. **Go to the Advanced tab** of the module
4. **Find the "Custom Attributes" section**
5. **Click "Add Attribute"** to add new attributes
6. **Enter the attribute name and value**
7. **Save the module**

The attributes will be automatically added to the module's HTML output on the frontend.

## 🛡️ Security

This plugin includes comprehensive security measures:

- **Input Validation**: All attribute names are validated using regex patterns
- **XSS Prevention**: Dangerous attributes like `onclick`, `javascript:` are blocked
- **Sanitization**: All values are properly sanitized using WordPress functions
- **Escaping**: Output is escaped to prevent code injection

## 🔧 Requirements

- **WordPress**: 5.0 or higher
- **PHP**: 7.2 or higher
- **Divi**: Divi theme or Divi Builder plugin
- **Tested up to**: WordPress 6.3

## 📁 Plugin Structure

```
divi-custom-attributes/
├── divi-custom-attributes.php          # Main plugin file
├── includes/
│   ├── class-divi-custom-attributes.php    # Main plugin class
│   ├── class-module-extension.php          # Module extension handler
│   └── class-attribute-renderer.php        # Frontend renderer
├── assets/
│   ├── js/
│   │   └── admin-interface.js              # Admin UI functionality
│   └── css/
│       ├── admin-styles.css                # Admin styling
│       └── frontend.css                    # Frontend styling
├── readme.txt                             # WordPress repository format
└── README.md                              # This file
```

## 🔌 Developer API

### Main Classes

- **`Divi_Custom_Attributes`**: Main plugin class and initialization
- **`Divi_Custom_Attributes_Module_Extension`**: Handles adding fields to Divi modules
- **`Divi_Custom_Attributes_Attribute_Renderer`**: Renders attributes on the frontend

### Hooks Used

- `et_pb_all_fields_unprocessed_{$slug}`: Adds custom fields to modules
- `et_module_shortcode_output`: Renders attributes on frontend output

### Data Structure

Attributes are stored as JSON in the module settings:
```json
[
  {
    "key": "data-custom",
    "value": "example-value"
  },
  {
    "key": "aria-label",
    "value": "Custom label"
  }
]
```

## ❓ FAQ

**Q: Does this plugin work with the Divi theme?**
A: Yes, this plugin works with both the Divi theme and the Divi Builder plugin.

**Q: Are there any security concerns with adding custom attributes?**
A: The plugin includes built-in security measures to prevent XSS attacks and malicious code. All attribute names and values are properly sanitized and validated.

**Q: Can I add multiple attributes to a single module?**
A: Yes, you can add as many custom attributes as needed to each module.

**Q: Will this affect my site's performance?**
A: No, the plugin is designed to be lightweight and only loads when the Divi Builder is active.

**Q: Can I use this for data attributes?**
A: Yes, data attributes (data-*) are fully supported and commonly used with this plugin.

## 📝 Changelog

### 1.0.0
- Initial release
- Add custom attributes interface to all Divi modules
- Frontend rendering of custom attributes
- Security measures for attribute validation
- Responsive admin interface

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/new-feature`
3. Commit your changes: `git commit -am 'Add new feature'`
4. Push to the branch: `git push origin feature/new-feature`
5. Submit a pull request

## 📄 License

This plugin is licensed under the GPL v2 or later.

```
Copyright (C) 2024 Make Good Team

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 👥 Team

**Created by**: [Make Good Team](https://wemakegood.org)  
**Author**: [Christopher Frazier](mailto:chris.frazier@wemakegood.org)

---

**Support**: For support, please [open an issue](https://github.com/WeMakeGood/divi-custom-attributes/issues) on GitHub.

**Website**: [wemakegood.org](https://wemakegood.org)