<?php
  $odometer_repeater = $instance['odometer_repeater'];
  // UNIQUE ID OF THE WIDGET
  global $sp_sow;
  $widget_id = 'sow-odometer-'.$sp_sow->getUniqueID( $instance );
  ?>
      	<div class="odometer-wrapper" id="<?php _e( $widget_id ); ?>">
          <?php
          foreach ($odometer_repeater as $value) {
            // _e( $value['icon_color'] );
            $odometer_icon = siteorigin_widget_get_icon( $value['odometer_icon'], array( '' ) );
          ?>
          	<div class=" item odometer-Txt">
              <?php ( $value['odometer_suffix'] ) ? _e( '<span class="odometer-suffix">'.$value['odometer_suffix'].'</span>' ) : ''?>
              <span class="odometer-value" data-count="<?php _e( $value['odometer_limit'] );?>">0</span>
              <?php ( $value['odometer_prefix'] ) ? _e( '<span class="odometer-prefix">'.$value['odometer_prefix'].'</span>' ) : ''?>
              <div class="odometer-desc">
                <?php _e( $odometer_icon ); ?><?php _e( $value['odometer_txt'] ); ?>
              </div>
            </div>
          <?php } ?>
        </div>
<style>
.odometer-wrapper{
  display: grid;
  grid-template-columns: repeat( <?php _e( $instance['odometer_normal'] ); ?> ,1fr);
  grid-gap: 10px;
  height:100%;
  background:#ebebeb;
}
.odometer-wrapper .odometer-Txt{
  text-align:center;
  /* font-size:40px; */
  font-weight:bold;
  text-transform:uppercase;
  padding: 10px;
}
@media(max-width:767px){
  .odometer-wrapper{
    width: 100%;
    grid-template-columns: repeat( <?php _e( $instance['odometer_mobile'] ); ?> ,1fr);
  }
}
@media only screen and (min-width:768px) and (max-width:768px){
  .odometer-wrapper{
    width: 100%;
    grid-template-columns: repeat( <?php _e( $instance['odometer_tablet'] ); ?> ,1fr);
  }
}
.odometer-wrapper .odometer-Txt span{display:inline-block;}
.odometer-wrapper .odometer-suffix,.odometer-wrapper .odometer-prefix{
  font-size: <?php _e($instance['odometer_font'])?>;
}
.odometer-value{font-size: <?php _e($instance['odometer_font'])?>}
.odometer-desc span{
  color: #ccc;
}
.odometer-desc{
  color: #888;
}
.odometer-desc .sow-fas{
  margin-right: 15px;
  font-size: 32px;
  /* float: left; */
  font-weight: 900;
}
/* @media(min-width:320px) and (max-width:767px){
.c-no{height:100%;}
.counter-Txt{margin-top:35px;}
.margin-bot-35{margin-bottom:35px;} */
</style>
<script>
var a = 0;
jQuery(window).scroll(function() {

  var oTop = jQuery('#<?php _e( $widget_id ); ?>').offset().top - window.innerHeight;
  if (a == 0 && jQuery(window).scrollTop() > oTop) {
    jQuery('.odometer-value').each(function() {
      var $this = jQuery(this),
        countTo = $this.attr('data-count');
        console.log('hiiii');
      jQuery({
        countNum: $this.text()
      }).animate({
          countNum: countTo
        },

        {

          duration: 7000,
          easing: 'swing',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text(this.countNum);
            //alert('finished');
          }

        });
    });
    a = 1;
  }

});
</script>
