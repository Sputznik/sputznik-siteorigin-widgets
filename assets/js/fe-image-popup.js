jQuery(document).ready(function () {
    jQuery('[id^="sputznik-popup-wrapper-"]').each(function () {
        var baseClass = jQuery(this).data('base-class');
        if (!baseClass) return;

        jQuery("[class*='" + baseClass + "-']").each(function () {
            var widget = jQuery(this);
            var classList = widget.attr("class").split(/\s+/);

            classList.forEach(function (cls) {
                if (!cls.startsWith(baseClass + "-")) return;

                var uniqueId = cls.replace(baseClass + "-", "");
                var modalId = '#global-sputznik-modal-' + baseClass;
                var contentId = '#content-' + baseClass + '-' + uniqueId;
                var content = jQuery(contentId);

                if (content.length && jQuery.trim(content.html()).length > 0) {
                    var trigger = widget.find("img, a").first();

                    trigger.css("cursor", "pointer").on("click", function (e) {
                        e.preventDefault();
                        jQuery('#global-modal-content-' + baseClass)
                            .html(content.html());
                        jQuery(modalId).removeAttr('aria-hidden');
                        jQuery(modalId).modal('show');
                    });
                }
            });
        });

        jQuery(document).on('hide.bs.modal', '#global-sputznik-modal-' + baseClass, function () {
            document.activeElement?.blur();
        });
    });
});
