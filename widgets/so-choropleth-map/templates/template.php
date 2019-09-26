<?php

  global $sp_sow;

  $data = array();

  if( isset( $instance['markers'] ) ){
    foreach( $instance['markers'] as $key => $marker ){
      if( isset( $marker['icon'] ) ){
        $instance['markers'][ $key ]['icon'] = $sp_sow->get_image_url( $marker['icon'] );
      }
    }
  }

  $instance['json_url'] = admin_url('admin-ajax.php?action=sp_combine_map_jsons');

  //echo "<pre>";
  //print_r( $instance );
  //echo "</pre>";
?>

<div data-json='<?php _e( wp_json_encode( $instance ) )?>' data-behaviour="choropleth-map"></div>
