<?php
/*
Plugin Name: SiteOrigin Widgets by Sputznik
Plugin URI:
Description:
Version: 1.0.0
Author: Sputznik
*/

define( 'SP_SOW_VERSION', time() ); // 1.1.7

class SP_SOW{

  function __construct(){
    add_filter( 'siteorigin_widgets_widget_folders', array( $this, 'addWidgetFolder' ) );

    add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );

    add_action( 'wp_ajax_sp_combine_map_jsons', array( $this, 'combineMapJsons' ) );
    add_action( 'wp_ajax_nopriv_sp_combine_map_jsons', array( $this, 'combineMapJsons' ) );
  }

  function addWidgetFolder( $folders ){
    $folders[] = plugin_dir_path( __FILE__ ).'widgets/';
    return $folders;
  }

  function get_image_url( $post_id ){
		if( $post_id ) return wp_get_attachment_url( $post_id );
		return false;
	}

  function getUniqueID( $data ){
		return substr( md5( json_encode( $data ) ), 0, 8 );
	}

  function map_assets(){
    wp_enqueue_style( 'sow-choropleth', plugin_dir_url(  __FILE__).'/assets/css/choropleth.css', array(), SP_SOW_VERSION );
    wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.css', array(), SP_SOW_VERSION );
    wp_enqueue_style( 'leaflet-marker', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css', array(), SP_SOW_VERSION );
    wp_enqueue_style( 'leaflet-marker-default', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css', array(), SP_SOW_VERSION );

    wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.4.0/dist/leaflet.js', array( 'jquery' ), SP_SOW_VERSION , true );
    wp_enqueue_script( 'leaflet-marker', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array( 'jquery', 'leaflet' ), SP_SOW_VERSION , true );
    wp_enqueue_script( 'leaflet-csv', plugin_dir_url( __FILE__ ).'/assets/js/leaflet.geocsv.js', array( 'leaflet' ), SP_SOW_VERSION , true );
    wp_enqueue_script( 'sow-choropleth', plugin_dir_url( __FILE__ ).'/assets/js/choropleth.js', array( 'jquery', 'leaflet-csv', 'leaflet-marker' ), SP_SOW_VERSION , true );
  }

  function assets(){
    wp_enqueue_style( 'buttonscript', plugin_dir_url(  __FILE__).'assets/css/sow.css', array(), SP_SOW_VERSION );
    wp_enqueue_script( 'buttonstyle', plugin_dir_url( __FILE__ ).'/assets/js/sow.js', array( 'jquery' ), SP_SOW_VERSION , true );
    wp_enqueue_script( 'odometer', plugin_dir_url( __FILE__ ).'/assets/js/odometer.js', array( 'jquery' ), SP_SOW_VERSION , true );

    $panels_data = get_post_meta( get_the_ID(), 'panels_data', true );

    if(empty($panels_data['widgets'])) return;

    global $wp_widget_factory;

    //echo serialize( $panels_data );

    //wp_die();

    // LOAD MAP ASSETS ONLY WHEN THE WIDGET IS ACTIVE AND HAS BEEN USED IN THE Page
    if( ( isset( $wp_widget_factory->widgets['SP_CHOROPLETH_MAP_WIDGET'] ) ) && ( strpos( serialize( $panels_data ), ':"SP_CHOROPLETH_MAP_WIDGET";' ) != false ) ){
      $this->map_assets();
    }

  }

  function modal( $modal_id, $modal_content, $modal_width = '600px' ){
    ?>
    <div id="<?php _e( $modal_id );?>" class="inline-modal" data-behaviour="inline-modal">
  		<div class="inline-overlay"></div>
  		<button type="button" class="close">&times;</button>
  		<div class="inline-modal-dialog" style="max-width:<?php _e( $modal_width );?>" role="document"><?php echo $modal_content;?></div>
  	</div>
    <?php
  }

  function getMapJsons(){
    $jsons = array( 'countries' => plugins_url( '/sputznik-siteorigin-widgets/assets/js/countries.json' ) );

    return apply_filters( 'sputznik-sow-jsons', $jsons );;
  }

  function combineMapJsons(){
    $data = array();

    $jsons = $this->getMapJsons();

    foreach( $jsons as $key => $json_file ){
      $strJsonFileContents = file_get_contents( $json_file );

      // Convert to array
      $data[ $key ] = json_decode( $strJsonFileContents, true );
    }

    echo wp_json_encode( $data );

    /*
    echo "<pre>";
    print_r( $data );
    echo "</pre>";
    */

    wp_die();
  }

}

global $sp_sow;
$sp_sow = new SP_SOW;
