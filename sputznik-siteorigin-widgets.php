<?php
/*
Plugin Name: SiteOrigin Widgets by Sputznik
Plugin URI:
Description:
Version: 1.0.0
Author: Sputznik
*/


class SP_SOW{

  function __construct(){
    add_filter( 'siteorigin_widgets_widget_folders', array( $this, 'addWidgetFolder' ) );

    add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
  }

  function addWidgetFolder( $folders ){
    $folders[] = plugin_dir_path( __FILE__ ).'widgets/';
    return $folders;
  }

  function getUniqueID( $data ){
		return substr( md5( json_encode( $data ) ), 0, 8 );
	}

  function assets(){
    wp_enqueue_style( 'buttonscript', plugin_dir_url(  __FILE__).'/assets/css/sow.css', array(), time() );
    wp_enqueue_script( 'buttonstyle', plugin_dir_url( __FILE__ ).'/assets/js/sow.js', array( 'jquery' ), time() , true );
  }

}

global $sp_sow;
$sp_sow = new SP_SOW;
