jQuery(document).ready(function () {
    var wrapper = jQuery('#sputznik-popup-wrapper');
    var baseClass = wrapper.data('base-class');

    if (!baseClass) return;

    jQuery("[class*='" + baseClass + "-']").each(function () {
        var widget = jQuery(this);
        var classList = widget.attr("class").split(/\s+/);

        jQuery.each(classList, function (i, cls) {
            if (cls.indexOf(baseClass + "-") === 0) {
                var uniqueId = cls.replace(baseClass + "-", "");
                var modalId = baseClass + "-" + uniqueId;
                var contentId = "#content-" + modalId;
                var content = jQuery(contentId);

                if (content.length && jQuery.trim(content.html()).length > 0) {
                    var imgOrLink = widget.find("img, a").first();

                    if (imgOrLink.length) {
                        imgOrLink.css("cursor", "pointer").on("click", function (e) {
                            e.preventDefault();
                            jQuery('#global-modal-content').html(content.html());
                            jQuery('#global-sputznik-modal').modal('show');
                        });
                    }
                }
            }
        });
    });
});
