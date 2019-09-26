<?php
  $odometer_repeater = $instance['odometer_repeater'];
  $odometer_delay = $instance['odometer_delay'];
  // UNIQUE ID OF THE WIDGET
  global $sp_sow;
  $widget_id = 'sow-odometer-'.$sp_sow->getUniqueID( $instance );
  ?>
      	<div class="odometer-wrapper" data-delay='<?php _e( $odometer_delay );?>' data-behaviour="sp-odometer"  id="<?php _e( $widget_id ); ?>">
          <?php
          foreach ($odometer_repeater as $value) {
            // _e( $value['icon_color'] );
            $odometer_icon = siteorigin_widget_get_icon( $value['odometer_icon'], array( '' ) );
          ?>
          	<div class=" item odometer-Txt">
              <?php ( $value['odometer_prefix'] ) ? _e( '<span class="odometer-prefix">'.$value['odometer_prefix'].'</span>' ) : ''?>
              <span class="odometer-value" data-count="<?php _e( $value['odometer_limit'] );?>">0</span>
              <?php ( $value['odometer_suffix'] ) ? _e( '<span class="odometer-suffix">'.$value['odometer_suffix'].'</span>' ) : ''?>
              <div class="odometer-desc">
                <?php if( $odometer_icon ): _e( $odometer_icon ); _e( $value['odometer_txt'] ); ?>
                <?php else:?>
                <div class="no-icon">
                  <?php _e( $value['odometer_txt'] );?>
                </div>
                <?php endif?>
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
.odometer-wrapper .odometer-suffix,.odometer-wrapper .odometer-prefix{
  font-size: <?php _e($instance['odometer_font']);?>;
  color: <?php _e($instance['counter_color']);?>;
}
.odometer-value{
  font-size: <?php _e($instance['odometer_font']);?>;
  color : <?php _e($instance['counter_color']);?>;
}

.odometer-desc, .odometer-desc span, .odometer-desc .no-icon {
  color: <?php _e($instance['desc_color']);?>;
}
.odometer-desc .no-icon{
  padding-top: 15px;
}

/* @media(min-width:320px) and (max-width:767px){
.c-no{height:100%;}
.counter-Txt{margin-top:35px;}
.margin-bot-35{margin-bottom:35px;} */
</style>
