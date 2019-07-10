<?php
/*
Widget Name: Sputznik Choropleth Map
Description: Map Widget that displays all the countries
Author: Samuel Thomas, Sputznik
Author URI:
Widget URI:
Video URI:
*/

class SP_MAP extends SiteOrigin_Widget{

  function __construct(){
    //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
    //Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'so-map',
      // The name of the widget for display purposes.
      __( 'Sputznik Choropleth Map ', 'siteorigin-widgets' ),
      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __( 'Map Widget that displays all the countries','siteorigin-widgets' ),
        'help'        => '',
      ),
      //The $control_options array, which is passed through to WP_Widget
      array(),
      //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
      array(
        'items' => array(
					'type' 	=> 'repeater',
					'label' => __( 'Regions' , 'siteorigin-widgets' ),
					'item_name'  => __( 'Region Item', 'siteorigin-widgets' ),
					'fields' => array(
            'region' => array(
							'type'     => 'select',
							'label'    => __( 'Select Region', 'siteorigin-widgets' ),
              'options'  => $this->getRegions()
						),
            'color' => array(
              'type' => 'color',
              'label' => __( 'Choose a color', 'siteorigin-widgets' ),
              'default' => '#bada55'
            ),
						'popup' => array(
							'type' 	=> 'tinymce',
							'label' => __( 'Description', 'siteorigin-widgets' )
						),
					)
				),
        'markers' => array(
					'type' 	=> 'repeater',
					'label' => __( 'Markers' , 'siteorigin-widgets' ),
					'item_name'  => __( 'Marker', 'siteorigin-widgets' ),
					'fields' => array(
            'lat' => array(
              'type'    => 'text',
              'default' => '0',
              'label'   => 'Latitude'
            ),
            'lng' => array(
              'type'    => 'text',
              'default' => '0',
              'label'   => 'Longitude'
            ),
						'popup' => array(
							'type' 	=> 'tinymce',
							'label' => __( 'Description', 'siteorigin-widgets' )
						),
					)
				),
        'region-lines' => array(
          'type'  => 'section',
          'label' => __( 'Region Styles', 'siteorigin-widgets' ),
          'fields' => array(
            'color' => array(
              'type'    => 'color',
              'default' => '#000000',
              'label'   => __( 'Boundary Color', 'siteorigin-widgets' )
            ),
            'opacity' => array(
              'type'    => 'number',
              'default' => 1,
              'label'   => __( 'Opacity', 'siteorigin-widgets' )
            ),
          )
        ),
        'map' => array(
          'type'    => 'section',
          'label'   => __( 'Map Styles', 'siteorigin-widgets' ),
          'fields'  => array(
            'base_url'  => array(
              'type'    => 'text',
              'default' => 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}',
              'label'   => 'Base Map URL'
            ),
            'attribution' => array(
              'type'    => 'text',
              'default' => 'ESRI World Light Gray | Map data © <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors & <a href="http://datameet.org" target="_blank">Data{Meet}</a>',
              'label'   => 'Map Attribution'
            )
          )
        )
      ),
      plugin_dir_path(__FILE__).'/widgets/so-map'
    );
  }

  function get_template_name($instance) {
		return 'template';
	}
	function get_template_dir($instance) {
		return 'templates';
	}
  function get_style_name($instance) {
    return '';
  }

  function getJsonURL(){
    return plugins_url( '/sputznik-siteorigin-widgets/assets/js/countries.json' );
  }

  function getJsonFile(){

    $json_file = $this->getJsonURL();

    $strJsonFileContents = file_get_contents( $json_file );

    // Convert to array
    $array = json_decode( $strJsonFileContents, true );

    return $array;
  }

  function getRegions(){

    $regions = array();

    $array = $this->getJsonFile();

    if( isset( $array['features'] ) ){
      foreach( $array['features'] as $row ){
        if( isset( $row['properties'] ) && isset( $row['properties']['SOVEREIGNT'] ) ){
          $regions[ $row['properties']['SOVEREIGNT'] ] = $row['properties']['SOVEREIGNT'];
        }
      }
    }

    return $regions;
  }

}

siteorigin_widget_register( 'so-map', __FILE__, 'SP_MAP' );
