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

        $unique_id = isset( $popup_item['unique_id'] ) ? sanitize_html_class( $popup_item['unique_id'] ) : 'popup';
        $custom_class = isset( $popup_item['custom_class'] ) ? sanitize_html_class( $popup_item['custom_class'] ) : '';
        $builder_content = ! empty( $popup_item['builder_content'] ) ? $popup_item['builder_content'] : '';

        $modal_id = $base_classname . '-' . $unique_id;
        ?>

        <div id="<?php echo esc_attr( $modal_id ); ?>" class="sow-modal fade custom-modal <?php echo esc_attr( $custom_class ); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <div class="modal-inner-content">
                            <?php
                            if ( function_exists( 'siteorigin_panels_render' ) && $sp_sow ) {
                                echo siteorigin_panels_render( 'w' . $modal_id, true, $builder_content );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>