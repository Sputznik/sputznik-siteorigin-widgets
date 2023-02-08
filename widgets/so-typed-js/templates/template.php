<?php
  $config      = $instance['typed_config'];
  $sp_sow      = SPUTZNIK_SOW::getInstance();
  $widget_id   = $sp_sow->getUniqueID( $instance );
  $data_attributes = array(
    'loop'        => !empty( $config['loop'] ) ? $config['loop'] : 0,
    'loop-count'  => !empty( $config['loop-count'] ) ? $config['loop-count'] : 'Infinity',
    'type-speed'  => !empty( $config['type_speed'] ) ? $config['type_speed'] : 40,
    'start-delay' => !empty( $config['start_delay'] ) ? $config['start_delay'] : 40,
    'back-speed'  => !empty( $config['back_speed'] ) ? $config['back_speed'] : 40,
    'back-delay'  => !empty( $config['back_delay'] ) ? $config['back_delay'] : 40,
  );

  $data_attributes_str = '';

  foreach ( $data_attributes as $key => $value) {
    $data_attributes_str .= "data-$key = $value ";
  }

  if( !empty( $instance['unique_id'] ) ){
    $data_attributes_str .=" id=".$instance['unique_id'];
  }

?>

<div class="sp-typed-js" data-behaviour="sp-typed-js" data-name="<?php _e( $widget_id ); ?>" <?php _e( $data_attributes_str );?>>
  <div id="sp-typed-js-ip-<?php _e( $widget_id ); ?>">
    <?php _e( $instance['content'] );?>
  </div>
  <span id="sp-typed-js-op-<?php _e( $widget_id ); ?>"></span>
</div>
