<?php
/*
Widget Name: Sputznik Map (Leaflet)
Description: Map Widget that displays all the countries
Author: Samuel Thomas, Sputznik
Author URI: https://sputznik.com/
Widget URI:
Video URI:
*/

class SP_CHOROPLETH_MAP_WIDGET extends SiteOrigin_Widget{

  function __construct(){

    //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
    $form_options = array(
      'markers' => array(
        'type' 	=> 'repeater',
        'label' => __( 'Markers' , 'siteorigin-widgets' ),
        'description' => 'Add markers and customize icons and popup descriptions',
        'item_name'  => __( 'Marker', 'siteorigin-widgets' ),
        'fields' => array(
          'icon' => array(
            'type'        => 'media',
            'library'     => 'image',
            'label'       => __(' Marker Icon', 'siteorigin-widgets' ),
            'description' => "Upload an image of 30px by 30px, or refer to <a target='_blank' href='https://sputznik.com'>this link</a>",
          ),
          'lat' => array(
            'type'    => 'text',
            'default' => '0',
            'label'   => 'Latitude',
            'description' => "If you don't know the lat/long, <a href='https://www.wikihow.com/Get-Latitude-and-Longitude-from-Google-Maps'>click here</a> to learn how to get it from google maps."
          ),
          'lng' => array(
            'type'    => 'text',
            'default' => '0',
            'label'   => 'Longitude'
          ),
          'popup'   => array(
            'type' 	=> 'tinymce',
            'label' => __( 'Popup Description', 'siteorigin-widgets' ),
            'description' => "If description is left empty, there will be no popup",
          ),
        )
      ),

      'regions' => array(
        'type'    => 'section',
        'label'   => __( 'Regions', 'siteorigin-widgets' ),
        'hide'    => true,
        'fields'  => $this->getRegionsFields()
      ),
      'region-lines' => array(
        'type'  => 'section',
        'hide'    => true,
        'label' => __( 'Region Styles', 'siteorigin-widgets' ),
        'fields' => array(
          'color' => array(
            'type'        => 'color',
            'default'     => '#000000',
            'label'       => __( 'Boundary Color', 'siteorigin-widgets' ),
            'description' => 'Choose a color for borders of all regions',
          ),
          /*
          REMOVED AS IT SEEMED LIKE AN UNNECESSARY FIELD
          'opacity' => array(
            'type'    => 'number',
            'default' => 1,
            'label'   => __( 'Opacity', 'siteorigin-widgets' )
          ),
          */
        )
      ),
      'map' => array(
        'type'    => 'section',
        'label'   => __( 'Map Styles', 'siteorigin-widgets' ),
        'hide'    => true,
        'fields'  => array(
          'base_url'  => array(
            'type'        => 'text',
            'default'     => 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}',
            'label'       => 'Base Map URL',
            'description' => 'Find more options for base maps <a target="_blank" href="https://leaflet-extras.github.io/leaflet-providers/preview/">here</a>'
          ),
          'attribution' => array(
            'type'        => 'text',
            'default'     => 'ESRI World Light Gray | Map data © <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> contributors',
            'label'       => 'Map Attribution',
            'description' => 'If you are using any other base map, provide the appropriate attribution'
          ),
          'desktop' => array(
            'type'    => 'section',
            'label'   => __( 'Desktop Specific Styles', 'siteorigin-widgets' ),
            'hide'    => true,
            'fields'  => $this->get_responsive_common_fields()
          ),
          'tablet' => array(
            'type'    => 'section',
            'label'   => __( 'Tablet Specific Styles', 'siteorigin-widgets' ),
            'hide'    => true,
            'fields'  => $this->get_responsive_common_fields()
          ),
          'mobile' => array(
            'type'    => 'section',
            'label'   => __( 'Mobile Specific Styles', 'siteorigin-widgets' ),
            'hide'    => true,
            'fields'  => $this->get_responsive_common_fields()
          )

        )
      )
    );

    // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
    // Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'so-choropleth-map',

      // The name of the widget for display purposes.
      __( 'Sputznik Map (Leaflet) ', 'siteorigin-widgets' ),

      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __( 'Map Widget that displays all the countries','siteorigin-widgets' ),
        'help'        => '',
      ),

      //The $control_options array, which is passed through to WP_Widget
      array(),
      $form_options,
      plugin_dir_path(__FILE__).'/widgets/so-choropleth-map'
    );
  }

  function get_responsive_common_fields(){
    return array(
      'zoom'  => array(
        'type'        => 'number',
        'default'     => 2,
        'label'       => 'Zoom Level',
        'description' => 'The level of zoom when the map opens for the first time'
      ),
      'lat' => array(
        'type'    => 'text',
        'default' => '0',
        'label'   => 'Latitude of Centre',
        'description' => 'Latitude of the centre of the map'
      ),
      'lng' => array(
        'type'    => 'text',
        'default' => '0',
        'label'   => 'Longitude of Centre',
        'description' => 'Longitude of the centre of the map'
      ),
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

  function getRegionsFields(){

    $sp_sow = SPUTZNIK_SOW::getInstance();

    $regions = array();

    $jsons = $sp_sow->getMapJsons();

    foreach ( $jsons as $key => $json_url ) {

      $regions[ $key ] = array(
        'type' 	      => 'repeater',
        'label'       => __( $key, 'siteorigin-widgets' ),
        'item_name'   => __( 'Region Item', 'siteorigin-widgets' ),
        'item_label' => array(
            'selector'     => "[id*='region']",
            'update_event' => 'change',
            'value_method' => 'val'
        ),
        'fields'      => array(
          'region'    => array(
            'type'    => 'select',
            'label'   => __( 'Select Region', 'siteorigin-widgets' ),
            'options' => $this->getRegionsOptions( $json_url )
          ),
          'label' => array(
            'type'        => 'text',
            'label'       => __('Label', 'siteorigin-widgets'),
            'description' => 'Use this to replace the name of the region with some custom text, if required'
          ),
          'color' => array(
            'type'    => 'color',
            'label'   => __( 'Choose a color for the region', 'siteorigin-widgets' ),
            'default' => '#bada55'
          ),
          'popup' => array(
            'type' 	      => 'tinymce',
            'label'       => __( 'Popup Description', 'siteorigin-widgets' ),
            'description' => "If description is left empty, there will be no popup",
          ),
        )
      );


    }

    return $regions;
  }

  function getRegionsOptions( $json_file ){
    $regions = array();

    $strJsonFileContents = file_get_contents( $json_file );

    // Convert to array
    $array = json_decode( $strJsonFileContents, true );

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

siteorigin_widget_register( 'so-choropleth-map', __FILE__, 'SP_CHOROPLETH_MAP_WIDGET' );
