(function($) {
    'use strict';

    // Custom field type for Divi Builder
    window.et_pb_custom_attributes_field = {
        init: function() {
            this.bindEvents();
            this.initializeExistingFields();
        },

        bindEvents: function() {
            $(document).on('click', '.divi-custom-attributes-add-button', this.addAttributeRow);
            $(document).on('click', '.divi-custom-attributes-remove-button', this.removeAttributeRow);
            $(document).on('change', '.divi-custom-attributes-input', this.updateFieldValue);
        },

        initializeExistingFields: function() {
            // Initialize any existing custom attribute fields
            $('.et-pb-option-custom_attributes').each(function() {
                var $container = $(this);
                var fieldValue = $container.find('input[type="hidden"]').val();
                
                if (fieldValue && fieldValue !== '[]') {
                    try {
                        var attributes = JSON.parse(fieldValue);
                        window.et_pb_custom_attributes_field.renderAttributes($container, attributes);
                    } catch (e) {
                        console.error('Error parsing custom attributes:', e);
                    }
                }
            });
        },

        addAttributeRow: function(e) {
            e.preventDefault();
            var $container = $(this).closest('.et-pb-option-custom_attributes');
            var $attributesList = $container.find('.divi-custom-attributes-list');
            
            var rowHtml = window.et_pb_custom_attributes_field.getAttributeRowHtml('', '');
            $attributesList.append(rowHtml);
            
            // Focus on the new attribute name input
            $attributesList.find('.divi-custom-attributes-key:last').focus();
        },

        removeAttributeRow: function(e) {
            e.preventDefault();
            var $row = $(this).closest('.divi-custom-attributes-row');
            var $container = $row.closest('.et-pb-option-custom_attributes');
            
            $row.remove();
            window.et_pb_custom_attributes_field.updateFieldValue.call($container.find('input[type="hidden"]')[0]);
        },

        updateFieldValue: function() {
            var $container = $(this).closest('.et-pb-option-custom_attributes');
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
            
            var $hiddenInput = $container.find('input[type="hidden"]');
            $hiddenInput.val(JSON.stringify(attributes));
            $hiddenInput.trigger('change');
        },

        renderAttributes: function($container, attributes) {
            var $attributesList = $container.find('.divi-custom-attributes-list');
            
            attributes.forEach(function(attribute) {
                var rowHtml = window.et_pb_custom_attributes_field.getAttributeRowHtml(attribute.key, attribute.value);
                $attributesList.append(rowHtml);
            });
        },

        getAttributeRowHtml: function(key, value) {
            return '<div class="divi-custom-attributes-row">' +
                '<div class="divi-custom-attributes-input-group">' +
                    '<label>' + DiviCustomAttributesAdmin.strings.attribute_name + '</label>' +
                    '<input type="text" class="divi-custom-attributes-key divi-custom-attributes-input" value="' + key + '" placeholder="data-custom" />' +
                '</div>' +
                '<div class="divi-custom-attributes-input-group">' +
                    '<label>' + DiviCustomAttributesAdmin.strings.attribute_value + '</label>' +
                    '<input type="text" class="divi-custom-attributes-value divi-custom-attributes-input" value="' + value + '" placeholder="value" />' +
                '</div>' +
                '<button type="button" class="divi-custom-attributes-remove-button" title="' + DiviCustomAttributesAdmin.strings.remove_attribute + '">' +
                    '<span class="dashicons dashicons-no-alt"></span>' +
                '</button>' +
            '</div>';
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        window.et_pb_custom_attributes_field.init();
    });

    // Hook into Divi Builder's field rendering system
    if (typeof window.et_pb_custom_field_types !== 'undefined') {
        window.et_pb_custom_field_types.custom_attributes = function($element) {
            var fieldValue = $element.find('input[type="hidden"]').val() || '[]';
            
            var html = '<div class="divi-custom-attributes-container">' +
                '<div class="divi-custom-attributes-help-text">' +
                    DiviCustomAttributesAdmin.strings.help_text +
                '</div>' +
                '<div class="divi-custom-attributes-list"></div>' +
                '<button type="button" class="divi-custom-attributes-add-button et_pb_button">' +
                    '<span class="dashicons dashicons-plus-alt"></span> ' + DiviCustomAttributesAdmin.strings.add_attribute +
                '</button>' +
            '</div>';
            
            $element.find('.et-pb-option-container').append(html);
            
            // Initialize with existing data
            if (fieldValue && fieldValue !== '[]') {
                try {
                    var attributes = JSON.parse(fieldValue);
                    window.et_pb_custom_attributes_field.renderAttributes($element, attributes);
                } catch (e) {
                    console.error('Error parsing custom attributes:', e);
                }
            }
        };
    }

})(jQuery);