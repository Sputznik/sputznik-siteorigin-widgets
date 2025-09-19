jQuery(document).ready(function () {
    jQuery('[id^="sputznik-popup-wrapper-"]').each(function () {
        var baseClass = jQuery(this).data('base-class');
        if (!baseClass) return;

        jQuery("[class*='" + baseClass + "-']").each(function () {
            var widget = jQuery(this);
            var classList = widget.attr("class").split(/\s+/);

            classList.forEach(function (cls) {
                if (!cls.startsWith(baseClass + "-")) return;

                var modalId = '#' + cls;

                if (jQuery(modalId).length) {
                    widget.find("img, a").first().css("cursor", "pointer").on("click", function (e) {
                        e.preventDefault();
                        jQuery(modalId).addClass('active').attr('aria-hidden', 'false');
                        jQuery('body').addClass('modal-open');
                    });
                }
            });
        });
    });

    // Close modal with animation
    jQuery(document).on('click', '.custom-modal', function (e) {
        if (jQuery(e.target).is('.custom-modal') || jQuery(e.target).hasClass('close')) {
            const modal = jQuery(this);
            modal.removeClass('active').attr('aria-hidden', 'true');
            jQuery('body').removeClass('modal-open');

        }
    });
});

