<?php

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

  //echo "<pre>";
  //print_r( $instance );
  //echo "</pre>";
?>

<div data-regions-url="<?php _e( $this->getJsonURL() );?>" data-json='<?php _e( wp_json_encode( $instance ) )?>' data-behaviour="choropleth-map"></div>
