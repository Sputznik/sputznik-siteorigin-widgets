<?php
 $overlay = !empty( $instance['video_overlay'] ) ? $instance['video_overlay']/10 : '0.4';
 $video_template = $instance['video_type'];
?>
<!-- SP HERO VIDEO -->
<div class="hero-video-wrapper sp-hero-video">
  <div class="video-wrapper">
    <?php include( $video_template.".php" ); ?>
  </div>
  <div class="overlay"></div>
  <!-- Bounce-up-down Button -->
  <div class="bounce-wrapper">
    <a class="bounce-in-btn" href="<?php _e( $instance['arrow_target'] ); ?>">
      <img src="<?php _e( SP_SOW_URI.'assets/images/sp-arrow-down.png' ); ?>">
    </a>
  </div>
  <!-- Bounce-up-down Button -->
</div><!-- SP HERO VIDEO  ends -->

<style media="screen">
.sp-hero-video .overlay{
  background: rgba(0,0,0,<?php _e( $overlay );?>);
}
</style>
