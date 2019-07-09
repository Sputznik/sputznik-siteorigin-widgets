<?php

  $data = array();

  if( isset( $instance['items'] ) ){
    foreach( $instance['items'] as $item ){
      if( isset( $item['region'] ) ){
        $data[ $item['region'] ] = $item;
      }
    }
  }


?>

<div data-regions-url="<?php _e( $this->getJsonURL() );?>" data-json='<?php _e( wp_json_encode( $data ) )?>' data-behaviour="choropleth-map"></div>
