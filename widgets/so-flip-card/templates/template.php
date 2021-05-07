<?php

  $sp_sow    = SPUTZNIK_SOW::getInstance();
  $widget_id = 'sow-flip-card-'.$sp_sow->getUniqueID( $instance );

  // CARD STYLES
  $card_styles = $instance['card_styles'];
  $front_face  = $card_styles['front'];
  $back_face   = $card_styles['back'];

?>
<ul class="list-unstyled flip-grid-4" id="<?php _e( $widget_id );?>">
  <?php foreach ( $instance['flip_cards_repeater'] as $flip_card ) : $image = wp_get_attachment_url( $flip_card['image'] ); ?>
    <li class="post-item">
      <div class="post-card">
        <div class="front" style="background-image: url(<?php echo( $image ? $image : '' );?>);">
          <h2 class="title"><?php echo( $flip_card['card_title'] ? $flip_card['card_title'] : '' );?></h2>
        </div>
        <a class="post-url" href="<?php echo( $flip_card['link'] ? $flip_card['link'] : '' ); ?>" role="button">
          <div class="back">
            <div class="back-inner" style="background-image: url(<?php echo( $image ? $image : '' );?>);"></div>
            <h4 class="title"><?php echo( $flip_card['card_title'] ? $flip_card['card_title'] : '' );?></h4>
            <div class="content">
              <?php echo( $flip_card['card_desc'] ? $flip_card['card_desc'] : '' );?>
            </div>
            <span class="btn">Read More</span>
          </div>
        </a>
      </div>

    </li>
  <?php endforeach;?>
</ul>


<style media="screen">

/* FRONT FACE */
<?php _e( '#'.$widget_id );?>.flip-grid-4 .post-card .front{
  background-color: <?php echo( $front_face['bg_color'] ? $front_face['bg_color'] : "#000000" );?>;
}

<?php _e( '#'.$widget_id );?>.flip-grid-4 .front > .title{
  color: <?php echo( $front_face['title_color'] ? $front_face['title_color'] : "#ffffff" );?>;
}

/* BACK FACE */
<?php _e( '#'.$widget_id );?>.flip-grid-4 .back{
  background-color: <?php echo( $back_face['bg_color'] ? $back_face['bg_color'] : "#000000" );?>;
}

<?php _e( '#'.$widget_id );?>.flip-grid-4 .back > .title{
  color: <?php echo( $back_face['title_color'] ? $back_face['title_color'] : "#ffffff" );?>;
}

<?php _e( '#'.$widget_id );?>.flip-grid-4 .back > .content{
  color: <?php echo( $back_face['desc_color'] ? $back_face['desc_color'] : "#ffffff" );?>;
}

<?php _e( '#'.$widget_id );?>.flip-grid-4 .back > .btn{
  color: <?php echo( $back_face['btn_color'] ? $back_face['btn_color'] : "#0f0e0e" );?>;
  background-color: <?php echo( $back_face['btn_bg_color'] ? $back_face['btn_bg_color'] : "#f5f1ed" );?>;
}

</style>
