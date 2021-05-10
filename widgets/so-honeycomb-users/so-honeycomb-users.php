<?php
/*
	Widget Name: Sputznik Honeycomb Users
	Description: Honeycomb users layout with modal.
	Author: Stephen Anil, Sputznik
	Author URI:	https://sputznik.com
	Widget URI:
	Video URI:
*/
class SP_HONEYCOMB_USERS extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'so-honeycomb-users',
			// The name of the widget for display purposes.
			__('Sputznik Honeycomb Users', 'siteorigin-widgets'),
			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Honeycomb users layout with modal.'),
				'help'        => '',
			),
			//The $control_options array, which is passed through to WP_Widget
			array(),
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'honeycomb_users' => array(
					'type' 	=> 'repeater',
					'label' => __( 'Panels' , 'siteorigin-widgets' ),
					'item_label' => array(
						'selector' => "[id*='user_name']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields' => array(
						'user_image' => array(
							'type' 		=> 'media',
							'label' 	=> __( 'Profile Picture', 'siteorigin-widgets' ),
							'choose' 	=> __( 'Choose image', 'siteorigin-widgets' ),
							'update' 	=> __( 'Set image', 'siteorigin-widgets' ),
							'library' 	=> 'image',
							'fallback' 	=> false
						),
						'user_name' => array(
							'type' 			=> 'text',
							'label' 		=> __( 'Name', 'siteorigin-widgets' ),
							'default' 	=> '',
						),
						'user_bio' => array(
			        'type' => 'tinymce',
			        'label' => __( 'About', 'siteorigin-widgets' ),
			        'default' => '',
			        'rows' => 10,
			        'default_editor' => 'tinymce'
				    ),
					)

				),

			),
			//The $base_folder path string.
			get_template_directory()."/widgets/so-honeycomb-users"
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
siteorigin_widget_register('so-honeycomb-users', __FILE__, 'SP_HONEYCOMB_USERS');
