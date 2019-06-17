<?php
/*
Plugin Name: SiteOrigin Widgets by Sputznik
Plugin URI:
Description:
Version: 1.0.0
Author: Sputznik
*/


add_filter( 'siteorigin_widgets_widget_folders',  function( $folders ){
  $folders[] = plugin_dir_path( __FILE__ ).'widgets/';
  return $folders;
} );


add_action( 'wp_enqueue_scripts', function(){
  wp_enqueue_style( 'buttonscript', plugin_dir_url(  __FILE__).'/assets/css/sow.css', array(), time() );
  wp_enqueue_script( 'buttonstyle', plugin_dir_url( __FILE__ ).'/assets/js/sow.js', array( 'jquery' ), time() , true );
} );
