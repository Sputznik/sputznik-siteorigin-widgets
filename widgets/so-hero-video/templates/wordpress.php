<?php if( !empty( $instance['video_url'] ) ):?>
  <video autoplay loop playsinline muted>
    <source src="<?php _e( $instance['video_url'] );?>" type="video/mp4">
  </video>
<?php endif;?>
