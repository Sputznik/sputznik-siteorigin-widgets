<?php
/*
Widget Name: Floating Button Widget
Description: Floating Button
Author: Steve
Author URI:
Widget URI:
Video URI:
*/

class Sp_Floating_Button extends SiteOrigin_Widget{

  function __construct(){
    //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
    //Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'so-floating-button',
      // The name of the widget for display purposes.
      __( 'Floating Button', 'siteorigin-widgets' ),
      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __('Floating Button','siteorigin-widgets'),
        'help'        => '',
      ),
      //The $control_options array, which is passed through to WP_Widget
      array(),
      //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
      array(
        'btn_url' => array(
            'type'    => 'link',
            'label'   => __('Type in your url','siteorigin-widget'),
            'default' => 'www.google.com',
        ),
        'btn_text' => array(
            'type'    => 'text',
            'label'   => __('Button Text','siteorigin-widget'),
            'default' => 'Button',
        ),
        'show_btn'  =>  array(
            'type'    =>  'text',
            'label'   =>  'Enter the row id',
            'default' =>  200
        ),

      ),
      plugin_dir_path(__FILE__).'/widgets/so-floating-button'
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


}

siteorigin_widget_register( 'so-floating-button', __FILE__, 'Sp_Floating_Button' );
