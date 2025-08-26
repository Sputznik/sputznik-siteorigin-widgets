jQuery(document).ready(function () {

    function normalizeClassPart(value) {
        return value
            .toLowerCase()
            .trim()
            //.replace(/\s+/g, '-')         // Replace 1+ spaces with hyphen
            .replace(/[^a-z0-9\-_]/g, '');  // Remove invalid characters
        //.replace(/\-+/g, '-'); 
    }

    function updateCombinedLabel(container) {
        const rawClassname = jQuery(container).find('input[name$="[classname]"]').val() || 'popup';
        const classname = normalizeClassPart(rawClassname);
        let usedClasses = [];

        jQuery(container).find('.siteorigin-widget-field-repeater .siteorigin-widget-field-repeater-item').each(function () {
            const uniqueIdRaw = jQuery(this).find('input[name*="[unique_id]"]').val() || '';
            const uniqueId = normalizeClassPart(uniqueIdRaw);
            const combined = classname + '-' + uniqueId;

            usedClasses.push(combined);

            const combinedLabelInput = jQuery(this).find('input[name*="[combined_label]"]');
            if (combinedLabelInput.length) {
                combinedLabelInput.val(combined);
            }
        });

        const usedClassField = jQuery(container).find('.siteorigin-widget-field-used_classes');
        if (usedClassField.length) {
            let html = '<strong>Classes used in this widget</strong>';
            html += '<span style="margin-left:10px; font-weight:normal; font-size:90%;">(click to copy)</span>';
            if (usedClasses.length > 0) {
                html += '<div style="margin-top:10px; border:#cde2ec solid 1px; padding:10px;">' +
                    usedClasses.map(function (cls) {
                        return '<code class="click-to-copy" data-copy="' + cls + '" title="Click to copy">' + cls + '</code>';
                    }).join(', ') +
                    '</div>';
            } else {
                html += '<div><code>No classes yet</code></div>';
            }
            usedClassField.html(html);
        }
    }

    function initForm(form) {
        updateCombinedLabel(form);

        jQuery(form).on('input', 'input[name$="[classname]"], input[name*="[unique_id]"]', function () {
            updateCombinedLabel(form);
        });
    }

    // Initialize existing forms on page load
    jQuery('.siteorigin-widget-form[data-id-base="so-image-popup"]').each(function () {
        initForm(this);
    });

    // Initialize dynamically loaded forms 
    jQuery(document).on('sowsetupform', function (e) {
        const form = jQuery(e.target).closest('.siteorigin-widget-form[data-id-base="so-image-popup"]');
        if (form.length) {
            initForm(form);
        }
    });

    // Click-to-copy (only for this widget)
    jQuery(document).on('click', '.siteorigin-widget-form[data-id-base="so-image-popup"] .click-to-copy', function () {
        const element = jQuery(this);
        const text = element.data('copy');
        if (!text) return;

        navigator.clipboard.writeText(text).then(() => {
            const original = element.text();
            element.text('Copied!');

            setTimeout(() => {
                element.text(original);
            }, 1000);

        }).catch(err => {
            console.error('Failed to copy text: ', err);
            const original = element.text();
            element.text('Failed to copy');
            setTimeout(() => {
                element.text(original);
            }, 2000);
        });
    });

});
