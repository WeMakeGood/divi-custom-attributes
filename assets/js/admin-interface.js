(function($) {
    'use strict';

    // Custom attributes handler for Divi Builder
    var DiviCustomAttributes = {
        init: function() {
            this.bindEvents();
            this.initializeFields();
        },

        bindEvents: function() {
            // Use delegation to handle dynamically added fields
            $(document).on('click', '.divi-custom-attributes-add-button', this.addAttributeRow);
            $(document).on('click', '.divi-custom-attributes-remove-button', this.removeAttributeRow);
            $(document).on('change keyup', '.divi-custom-attributes-input', this.updateFieldValue);
            
            // Initialize when Divi Builder loads fields
            $(document).on('et_builder_api_rendered', this.initializeFields);
        },

        initializeFields: function() {
            // Look for custom_attributes textarea fields and convert them
            $('.et-pb-option-custom_attributes textarea').each(function() {
                var $textarea = $(this);
                var $container = $textarea.closest('.et-pb-option-custom_attributes');
                
                if (!$container.hasClass('divi-custom-attributes-initialized')) {
                    DiviCustomAttributes.convertTextareaToCustomUI($textarea);
                    $container.addClass('divi-custom-attributes-initialized');
                }
            });
        },

        convertTextareaToCustomUI: function($textarea) {
            var $container = $textarea.closest('.et-pb-option-custom_attributes');
            var fieldValue = $textarea.val() || '[]';
            
            // Hide the original textarea
            $textarea.hide();
            
            // Create custom UI
            var customUI = '<div class="divi-custom-attributes-container">' +
                '<div class="divi-custom-attributes-help-text">' +
                    (DiviCustomAttributesAdmin.strings.help_text || 'Add custom HTML attributes to this module.') +
                '</div>' +
                '<div class="divi-custom-attributes-list"></div>' +
                '<button type="button" class="divi-custom-attributes-add-button et_pb_button">' +
                    '<span class="dashicons dashicons-plus-alt"></span> ' + 
                    (DiviCustomAttributesAdmin.strings.add_attribute || 'Add Attribute') +
                '</button>' +
            '</div>';
            
            $textarea.after(customUI);
            
            // Initialize with existing data
            if (fieldValue && fieldValue !== '[]') {
                try {
                    var attributes = JSON.parse(fieldValue);
                    DiviCustomAttributes.renderAttributes($container, attributes);
                } catch (e) {
                    console.error('Error parsing custom attributes:', e);
                }
            }
        },

        addAttributeRow: function(e) {
            e.preventDefault();
            var $container = $(this).closest('.et-pb-option-custom_attributes');
            var $attributesList = $container.find('.divi-custom-attributes-list');
            
            var rowHtml = DiviCustomAttributes.getAttributeRowHtml('', '');
            $attributesList.append(rowHtml);
            
            // Focus on the new attribute name input
            $attributesList.find('.divi-custom-attributes-key:last').focus();
        },

        removeAttributeRow: function(e) {
            e.preventDefault();
            var $row = $(this).closest('.divi-custom-attributes-row');
            var $container = $row.closest('.et-pb-option-custom_attributes');
            
            $row.remove();
            DiviCustomAttributes.updateFieldValue($container);
        },

        updateFieldValue: function($container) {
            // If called from an event, get the container
            if (typeof $container === 'object' && $container.target) {
                $container = $($container.target).closest('.et-pb-option-custom_attributes');
            }
            
            var attributes = [];
            
            $container.find('.divi-custom-attributes-row').each(function() {
                var key = $(this).find('.divi-custom-attributes-key').val();
                var value = $(this).find('.divi-custom-attributes-value').val();
                
                if (key && value) {
                    attributes.push({
                        key: key,
                        value: value
                    });
                }
            });
            
            var $textarea = $container.find('textarea');
            $textarea.val(JSON.stringify(attributes));
            $textarea.trigger('change');
        },

        renderAttributes: function($container, attributes) {
            var $attributesList = $container.find('.divi-custom-attributes-list');
            
            attributes.forEach(function(attribute) {
                var rowHtml = DiviCustomAttributes.getAttributeRowHtml(attribute.key, attribute.value);
                $attributesList.append(rowHtml);
            });
        },

        getAttributeRowHtml: function(key, value) {
            return '<div class="divi-custom-attributes-row">' +
                '<div class="divi-custom-attributes-input-group">' +
                    '<label>' + (DiviCustomAttributesAdmin.strings.attribute_name || 'Attribute Name') + '</label>' +
                    '<input type="text" class="divi-custom-attributes-key divi-custom-attributes-input" value="' + key + '" placeholder="data-custom" />' +
                '</div>' +
                '<div class="divi-custom-attributes-input-group">' +
                    '<label>' + (DiviCustomAttributesAdmin.strings.attribute_value || 'Attribute Value') + '</label>' +
                    '<input type="text" class="divi-custom-attributes-value divi-custom-attributes-input" value="' + value + '" placeholder="value" />' +
                '</div>' +
                '<button type="button" class="divi-custom-attributes-remove-button" title="' + (DiviCustomAttributesAdmin.strings.remove_attribute || 'Remove Attribute') + '">' +
                    '<span class="dashicons dashicons-no-alt"></span>' +
                '</button>' +
            '</div>';
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        DiviCustomAttributes.init();
    });

    // Also initialize when Divi Builder loads
    $(window).on('et_builder_api_ready', function() {
        DiviCustomAttributes.init();
    });

})(jQuery);