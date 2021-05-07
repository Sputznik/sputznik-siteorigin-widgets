<?php
/*
	Widget Name: Sputznik Flip Card
	Description: Flip Card Widget
	Author: Stephen Anil, Sputznik
	Author URI:	https://sputznik.com
	Widget URI:
	Video URI:
*/
class SP_FLIP_CARD extends SiteOrigin_Widget{

  function __construct(){
    //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
    //Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'so-flip-card',
      // The name of the widget for display purposes.
      __( 'Sputznik Flip Card', 'siteorigin-widgets' ),
      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __( 'Sputznik Flip Card', 'siteorigin-widgets' ),
        'help'        => '',
      ),
      //The $control_options array, which is passed through to WP_Widget
      array(),
      //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
      array(
        'flip_cards_repeater' => array(
          'type'      => 'repeater',
          'label'     => 'Cards Repeater',
          'item_label' => array(
						'selector' => "[id*='card_title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
          'fields'    =>  array(
            'card_title'  =>  array(
              'type'  =>  'text',
              'label' =>  __( 'Title', 'siteorigin-widgets' ),
              'default' =>  '',
            ),
            'card_desc' => array(
			        'type' 	=> 'textarea',
			        'label' => __( 'Description', 'siteorigin-widgets' )
				    ),
            'image' => array(
							'type' 		=> 'media',
							'label' 	=> __( 'Background Image', 'siteorigin-widgets' ),
							'choose' 	=> __( 'Choose image', 'siteorigin-widgets' ),
							'update' 	=> __( 'Set image', 'siteorigin-widgets' ),
							'library' 	=> 'image',
							'fallback' 	=> false
						),
            'link' => array(
              'type'    => 'link',
              'label'   => __('Type in your url','siteorigin-widgets'),
              'default' => '',
            ),
          )
        ),
        'card_styles' => array(
          'type'    => 'section',
          'label'   => __( 'Flip Card Styles', 'siteorigin-widgets' ),
          'hide'    => true,
          'fields'  => array(
            'front' => array(
              'type'    => 'section',
              'label'   => __( 'Front Face', 'siteorigin-widgets' ),
              'hide'    => true,
              'fields'  => $this->get_front_face_fields()
            ),
            'back' => array(
              'type'    => 'section',
              'label'   => __( 'Back Face', 'siteorigin-widgets' ),
              'hide'    => true,
              'fields'  => $this->get_back_face_fields()
            ),
          )
        ),
			),
      //The $base_folder path string.
      plugin_dir_path(__FILE__).'/widgets/so-flip-card'
    );
  }

  function get_front_face_fields(){
    return array(
      'title_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Title Color', 'siteorigin-widgets' ),
      	'default' 	=> '#ffffff'
      ),
      'bg_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Background Color', 'siteorigin-widgets' ),
      	'default' 	=> '#0f0e0e',
        'description' => 'Will be visible only when there is no background image'
      ),
    );
  }

  function get_back_face_fields(){
    return array(
      'title_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Title Color', 'siteorigin-widgets' ),
      	'default' 	=> '#ffffff'
      ),
      'desc_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Description Color', 'siteorigin-widgets' ),
      	'default' 	=> '#ffffff'
      ),
      'bg_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Background Color', 'siteorigin-widgets' ),
      	'default' 	=> '#0f0e0e'
      ),
      'btn_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Button Color', 'siteorigin-widgets' ),
      	'default' 	=> '#0f0e0e'
      ),
      'btn_bg_color' => array(
      	'type' 		=> 'color',
      	'label' 	=> __( 'Button Background', 'siteorigin-widgets' ),
      	'default' 	=> '#f5f1ed'
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


}

siteorigin_widget_register( 'so-flip-card', __FILE__, 'SP_FLIP_CARD' );
