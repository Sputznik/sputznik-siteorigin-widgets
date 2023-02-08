<?php
/*
	Widget Name: Sputznik Typed JS
	Description: Sputznik SOW with TYPED.JS within the page builder.
	Author: Stephen Anil, Sputznik
	Author URI:	https://sputznik.com
	Widget URI:
	Video URI:
*/
class SP_TYPED_JS extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'so-typed-js',
			// The name of the widget for display purposes.
			__('Sputznik Typed JS', 'siteorigin-widgets'),
			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Sputznik SOW with TYPED.JS within the page builder.'),
				'help'        => '',
			),
			//The $control_options array, which is passed through to WP_Widget
			array(),
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'content' => array(
					'type' => 'tinymce',
					'label' => __( 'Content', 'siteorigin-widgets' ),
					'default' => '',
					'rows' => 10,
					'default_editor' => 'tinymce'
				),
				'unique_id'  =>  array(
          'type'        => 'text',
          'label'       => 'Unique ID',
          'description' => 'Use this ID to explicitly change the styles.',
          'default'     => ''
        ),
				'typed_config' => array(
	        'type'  => 'section',
	        'hide'    => true,
	        'label' => __( 'Config', 'siteorigin-widgets' ),
	        'fields' => array(
						'type_speed' => array(
			        'type' => 'number',
			        'label' => __( 'Type Speed', 'siteorigin-widgets' ),
			        'default' => '40',
							'description'	=> 'Typing speed in milliseconds'
				    ),
						'start_delay' => array(
			        'type' => 'number',
			        'label' => __( 'Start Delay', 'siteorigin-widgets' ),
			        'default' => '40',
							'description'	=> 'Time before typing starts in milliseconds'
				    ),
						'back_speed' => array(
			        'type' => 'number',
			        'label' => __( 'Back Speed', 'siteorigin-widgets' ),
			        'default' => '40',
							'description'	=> 'Backspacing speed in milliseconds'
				    ),
						'back_delay' => array(
			        'type' => 'number',
			        'label' => __( 'Back Delay', 'siteorigin-widgets' ),
			        'default' => '40',
							'description'	=> 'Time before backspacing in milliseconds'
				    ),
						'loop_count' => array(
			        'type' => 'number',
			        'label' => __( 'Total Loops', 'siteorigin-widgets' ),
			        'default' => '',
							'description'	=> 'Set to infinite loop by default. Will not work if loop attribute is not checked.'
				    ),
						'loop' => array(
			        'type' 	=> 'checkbox',
			        'label' => __( 'Loop through the strings ?', 'siteorigin-widgets' ),
			        'default' => false
				    )
	        )
				)
			),
			//The $base_folder path string.
			get_template_directory()."/widgets/so-typed-js"
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
siteorigin_widget_register('so-typed-js', __FILE__, 'SP_TYPED_JS');
