<?php
/**
 * Template for Sputznik Image Popup Widget
 */
$sp_sow = class_exists('SPUTZNIK_SOW') ? SPUTZNIK_SOW::getInstance() : null;

if ( empty( $instance['popup_items'] ) || ! is_array( $instance['popup_items'] ) ) {
    return;
}

$base_classname = ! empty( $instance['classname'] ) ? sanitize_html_class( $instance['classname'] ) : 'popup';

foreach ( $instance['popup_items'] as $popup_item ):

    $unique_id = isset( $popup_item['unique_id'] ) ? sanitize_html_class( $popup_item['unique_id'] ) : 'popup-' . uniqid();
    $custom_class = isset( $popup_item['custom_class'] ) ? sanitize_html_class( $popup_item['custom_class'] ) : '';
    $builder_content = ! empty( $popup_item['builder_content'] ) ? $popup_item['builder_content'] : '';
    $base_classname = ! empty( $instance['classname'] ) ? sanitize_html_class( $instance['classname'] ) : 'popup';

    $modal_id = $base_classname . '-' . $unique_id;
    $anchor_link = '#' . $modal_id;
    ?>
    <div class="so-widget-sp-button-widget <?php echo esc_attr( $custom_class ); ?>">
        <div id="<?php echo esc_attr( $modal_id ); ?>" class="modal sow-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">×</button>

                        <?php
                        if ( function_exists( 'siteorigin_panels_render' ) && $sp_sow && ! empty( $builder_content ) ) {
                            echo siteorigin_panels_render( 'w' . $modal_id, true, $builder_content );
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const baseClass = <?php echo json_encode( $base_classname ); ?>;

    console.log("Base class for popup items:", baseClass);

    document.querySelectorAll("[class*='" + baseClass + "-']").forEach(function (widget) {
      const classList = widget.className.split(/\s+/);
      classList.forEach(function (cls) {
        if (cls.startsWith(baseClass + "-")) {
          const uniqueId = cls.replace(baseClass + "-", "");
          const modalId = baseClass + "-" + uniqueId;
          const modal = document.getElementById(modalId);
          if (modal) {
            const img = widget.querySelector("img") || widget.querySelector("a");
            if (img) {
              img.style.cursor = "pointer";
              img.addEventListener("click", function () {
                if (typeof jQuery !== "undefined" && typeof jQuery(modal).modal === "function") {
                  jQuery(modal).modal("show");
                } else {
                  modal.style.display = "block";
                }
              });
            }
          }
        }
      });
    });
  });
</script>