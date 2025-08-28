<?php
/**
 * Template for Sputznik Image Popup Widget
 */
$sp_sow = class_exists('SPUTZNIK_SOW') ? SPUTZNIK_SOW::getInstance() : null;

if ( empty( $instance['popup_items'] ) || ! is_array( $instance['popup_items'] ) ) {
    return;
}

$base_classname = ! empty( $instance['classname'] ) ? sanitize_html_class( $instance['classname'] ) : 'popup';
?>

<div id="sputznik-popup-wrapper-<?php echo esc_attr( $base_classname ); ?>" data-base-class="<?php echo esc_attr( $base_classname ); ?>">
    <?php foreach ( $instance['popup_items'] as $popup_item ):
        $unique_id = isset( $popup_item['unique_id'] ) ? sanitize_html_class( $popup_item['unique_id'] ) : 'popup-';
        $custom_class = isset( $popup_item['custom_class'] ) ? sanitize_html_class( $popup_item['custom_class'] ) : '';
        $builder_content = ! empty( $popup_item['builder_content'] ) ? $popup_item['builder_content'] : '';

        $modal_id = $base_classname . '-' . $unique_id;
        $content_id = 'content-' . $modal_id;
        ?>

        <!-- injecting the content to a hidden container -->
        <div id="<?php echo esc_attr( $content_id ); ?>" class="popup-content" style="display:none;">
            <?php
            if ( function_exists( 'siteorigin_panels_render' ) && $sp_sow && ! empty( $builder_content ) ) {
                echo siteorigin_panels_render( 'w' . $modal_id, true, $builder_content );
            }
            ?>
        </div>

    <?php endforeach; ?>

    <!-- only one global modal skeleton -->
    <div id="global-sputznik-modal-<?php echo esc_attr( $base_classname ); ?>" class="modal sow-modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <div id="global-modal-content-<?php echo esc_attr( $base_classname ); ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>

