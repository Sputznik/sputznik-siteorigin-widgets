<?php
/*
Widget Name: Sputznik Counter
Description: Display one or more animated odometer statistics in a multi-column grid.
Author: Stephen Anil, Sputznik
Author URI: https://sputznik.com/
Widget URI:
Video URI:
*/
class SP_ODOMETER extends SiteOrigin_Widget{
  function __construct(){
    $useable_units = array( 'px' );
    $form_options = array(
      'odometer_repeater' => array(
        'type'      => 'repeater',
        'label'     => 'Counters',
        'item_name' =>  __( 'Add Counter', 'siteorigin-widgets' ),
        'fields'    =>  array(
          'odometer_icon' => array(
            'type' => 'icon',
            'label' => __( 'Select an icon', 'siteorigin-widgets' ),
          ),
          'odometer_txt'  =>  array(
            'type'  =>  'text',
            'label' =>  __( 'Title', 'siteorigin-widgets' ),
            'default' =>  '',
          ),
          'odometer_limit'  =>  array(
            'type'  =>  'text',
            'label' =>  __( 'Counter Value', 'siteorigin-widgets' ),
            'default' =>  '50',
          ),
          'odometer_prefix' => array(
            'type'  =>  'text',
            'label' =>  __( 'Prefix', 'siteorigin-widgets' ),
            'description' =>  __( 'The prefix string for the counter. Examples include currency symbols like $ to indicate a monetary value.',
                              'siteorigin-widgets' )
          ),
          'odometer_suffix' => array(
            'type'  =>  'text',
            'label' =>  __( 'Suffix', 'siteorigin-widgets' ),
            'description' =>  __( 'The suffix string for the counter. Examples include strings like hr for hours or m for million.',
                              'siteorigin-widgets' )
          ),

        )
      ),
        'odometer_font'  => array(
          'type' => 'multi-measurement',
          'label' => __( 'Font Size for limit, suffix, prefix','siteorigin-widgets' ),
          'autofill' => true,
          'default' => '20px',
          'measurements' => array(
            'font_size' => array(
              'units' => $useable_units,
            ),
          ),
        ),
        'counter_color' => array(
          'type' => 'color',
          'label' => __( 'Choose a Color for Counter, Suffix & Prefix', 'widget-form-fields-text-domain' ),
          'default' => '#333',
        ),
        'desc_color' => array(
          'type' => 'color',
          'label' => __( 'Choose a Color for Icon and Title ', 'widget-form-fields-text-domain' ),
          'default' => '#ddd',
        ),
        'odometer_delay' => array(
          'type' => 'number',
          'label' => __( 'Counter Delay', 'siteorigin-widgets' ),
          'default' => 7000,
          'description' =>  __( 'Number of seconds that the animation lasts. Example, 2seconds = 2000 milliseconds','siteorigin-widgets' )
        ),
      'odometer_normal' => array(
        'type' => 'slider',
        'label' => __( 'Counters per row', 'siteorigin-widgets' ),
        'default' => 1,
        'min' => 1,
        'max' => 4,
        'integer' => true
      ),
      'odometer_tablet' => array(
        'type' => 'slider',
        'label' => __( 'Counters per row in Tablet Resolution ', 'siteorigin-widgets' ),
        'default' => 1,
        'min' => 1,
        'max' => 4,
        'integer' => true
      ),
      'odometer_mobile' => array(
        'type' => 'slider',
        'label' => __( 'Counters per row in Mobile Resolution', 'siteorigin-widgets' ),
        'default' => 1,
        'min' => 1,
        'max' => 4,
        'integer' => true
      )
    );
    parent::__construct(
      'so-odometer',
      __('Sputznik Counter','siteorigin-widgets'),
      array(
        'description' =>  __('Display one or more animated odometer statistics in a multi-column grid.','siteorigin-widgets'),
        'help'        =>  ''
      ),
      array(),
      $form_options,
      plugin_dir_path(__FILE__).'/widgets/so-odometer'
    );
  }//construct function ends here
  function get_template_name($instance){
    return 'template';
  }
  function get_template_dir($instance) {
    return 'templates';
  }
  function get_style_name($instance){
    return '';
    }
}
siteorigin_widget_register('so-odometer',__FILE__,'SP_ODOMETER');

  ?>
