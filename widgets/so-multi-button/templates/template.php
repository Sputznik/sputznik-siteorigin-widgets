<?php

  global $sp_sow;

  $widget_id = $sp_sow->getUniqueID( $instance );

  $anchor_link = $instance['is_modal'] ? '#modal-'.$widget_id : sow_esc_url( $instance['link'] );

  $parent_classes = array( 'sp-btn-parent' );

  $anchor_classes = array( 'sp-btn' );
  if( isset( $instance['is_floating'] ) && $instance['is_floating'] ){
    $anchor_classes[] = 'sp-floating-btn';
  }
  else{
    $parent_classes[] = isset( $instance['align'] ) ? 'align-'.$instance['align'] : 'align-left';
  }
  $anchor_class = implode( " ", $anchor_classes );

  $parent_class = implode( " ", $parent_classes );

?>
<div class="<?php _e( $parent_class );?>">
  <a class="<?php _e( $anchor_class );?>" <?php if( $instance['is_modal'] ):?>data-toggle='modal'<?php endif;?> href="<?php echo $anchor_link; ?>" data-popup="<?php echo $instance['target_id']?>"><?php echo $instance['btn_text']?></a>
</div>

<!-- MODALS FROM THE INLINE POSTS -->
<?php if( function_exists( 'siteorigin_panels_render' ) ): ?>
  <div id="<?php _e( 'modal-'.$widget_id );?>" class="inline-modal" data-behaviour="inline-modal">
    <div class="inline-overlay"></div>
    <button type="button" class="close">&times;</button>
    <div class="inline-modal-dialog" role="document">
      <?php echo siteorigin_panels_render( 'w'.$widget_id, true, $instance['modal_builder'] );?>
    </div>
  </div>
<?php endif;?>
<!-- END OF MODALS -->
