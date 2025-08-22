(function ($) {
    function normalizeClassPart(value) {
        return value
            .toLowerCase()
            .trim()
            //.replace(/\s+/g, '-')         // Replace 1+ spaces with hyphen
            .replace(/[^a-z0-9\-_]/g, '')   // Remove invalid characters
        //.replace(/\-+/g, '-');        // Replace multiple hyphens with one
    }

    function updateCombinedLabel(container) {
        const rawClassname = container.find('input[name$="[classname]"]').val() || 'popup';
        const classname = normalizeClassPart(rawClassname);
        let usedClasses = [];

        container.find('.siteorigin-widget-field-repeater .siteorigin-widget-field-repeater-item').each(function () {
            const uniqueIdRaw = $(this).find('input[name*="[unique_id]"]').val() || '';
            const uniqueId = normalizeClassPart(uniqueIdRaw);
            const combined = classname + '-' + uniqueId;

            if (uniqueId) usedClasses.push(combined);

            $(this).find('.siteorigin-widget-field-html').each(function () {
                const label = $(this).find('label').text().trim();
                if (label === 'Generated Class') {
                    $(this).html('<label>Generated Class</label><div><code>' + combined + '</code></div>');
                }
            });


            const repeaterItem = $(this);

            const uniqueIdInput = repeaterItem.find('input[name*="[unique_id]"]');
            const combinedLabelInput = repeaterItem.find('input[name*="[combined_label]"]');

            if (!uniqueIdInput.length || !combinedLabelInput.length) return;

            combinedLabelInput.val(combined);
        });

        const usedClassField = container.find('.siteorigin-widget-field-used_classes');

        if (usedClassField.length) {
            let html = '<strong>Classes used in this widget</strong>';
            if (usedClasses.length > 0) {
                // html += '<div style="margin-top:10px; border:#cde2ec solid 1px; padding:10px;"><code>' + usedClasses.join('</code>, <code>') + '</code></div>';
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

    $(document).on('sowsetupform', function (e) {
        const container = $(e.target).closest('.siteorigin-widget-form');
        if (!container.length) return;

        updateCombinedLabel(container);

        container.on('input', 'input[name$="[classname]"], input[name*="[unique_id]"]', function () {
            updateCombinedLabel(container);
        });
    });

    $(document).on('click', '.click-to-copy', function () {
        const $this = $(this);
        const text = $this.data('copy');
        if (!text) return;

        const temp = $('<input>');
        $('body').append(temp);
        temp.val(text).select();
        document.execCommand('copy');
        temp.remove();

        $this.attr('title', 'Copied!').tooltip('show');

        setTimeout(() => {
            $this.attr('title', 'Click to copy');
        }, 1000);
    });

    $(document).on('mouseleave', '.click-to-copy', function () {
        $(this).attr('title', 'Click to copy');
    });

})(jQuery);
