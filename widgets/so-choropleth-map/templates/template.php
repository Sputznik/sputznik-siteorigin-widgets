<?php

  $sp_sow = SPUTZNIK_SOW::getInstance();

  $data = array();

  if( isset( $instance['markers'] ) ){
    foreach( $instance['markers'] as $key => $marker ){
      if( isset( $marker['icon'] ) ){
        $instance['markers'][ $key ]['icon'] = $sp_sow->get_image_url( $marker['icon'] );
      }
    }
  }

  $instance['json_url'] = admin_url('admin-ajax.php?action=sp_combine_map_jsons');

	SPUTZNIK_SOW::getInstance()->browserData( 'sp_map_data', $instance );

  //echo "<pre>";
  //print_r( $instance );
  //echo "</pre>";
?>

<div data-behaviour="choropleth-map"></div>
