<?php

  global $sp_sow;

  $data = array();

  $instance['regions'] = array();

  if( isset( $instance['items'] ) ){
    foreach( $instance['items'] as $item ){
      if( isset( $item['region'] ) ){
        $data[ $item['region'] ] = $item;

        $instance[ 'regions' ][ $item['region'] ] = $item;

      }
    }
  }
  unset( $instance['items'] );

  if( isset( $instance['markers'] ) ){
    foreach( $instance['markers'] as $key => $marker ){
      if( isset( $marker['icon'] ) ){
        $instance['markers'][ $key ]['icon'] = $sp_sow->get_image_url( $marker['icon'] );
      }
    }
  }

  /*
  echo "<pre>";
  print_r( $instance );
  echo "</pre>";

  return '';
  */

?>

<div data-regions-url="<?php _e( $this->getJsonURL() );?>" data-json='<?php _e( wp_json_encode( $instance ) )?>' data-behaviour="choropleth-map"></div>
