<?php
/*
	Widget Name: Sputznik Hero Video
	Description: Hero Video Widget
	Author: Stephen Anil, Sputznik
	Author URI: https://sputznik.com
	Widget URI:
	Video URI:
*/
class SP_HERO_VIDEO extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'so-hero-video',
			// The name of the widget for display purposes.
			__('Sputznik Hero Video', 'siteorigin-widgets'),
			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __( 'Sputznik Hero Video', 'siteorigin-widgets' ),
				'help'        => '',
			),
			//The $control_options array, which is passed through to WP_Widget
			array(),
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'video_type' => array(
	        'type'    => 'select',
	        'label'   => __( 'Choose video type', 'siteorigin-widgets' ),
	        'options' => array(
						'vimeo'     => 'Vimeo',
						'wordpress'	=> 'Self Hosted'
					),
					'state_emitter' => array(
	        	'callback' 	=> 'select',
	        	'args' 			=> array( 'video_type' )
	    		),
	      ),
				'video_id' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'Video ID', 'siteorigin-widgets' ),
					'default' 	=> '',
					'state_handler' => array(
						'video_type[vimeo]' 		=> array('show'),
		        'video_type[wordpress]' => array('hide')
		    	),
				),
				'video_url' => array(
	        'type' 		=> 'link',
	        'label' 	=> __( 'Video URL', 'siteorigin-widgets' ),
					'state_handler' => array(
						'video_type[vimeo]' 		=> array('hide'),
		        'video_type[wordpress]' => array('show')
		    	),
	      ),
				'arrow_target' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'Target Id', 'siteorigin-widgets' ),
					'default' 	=> '',
				),
				'video_overlay' => array(
					'type' 				=> 'slider',
					'label' 			=> __( 'Video Overlay', 'siteorigin-widgets' ),
					'default' 		=> 4,
					'min' 				=> 0,
					'max'					=> 10,
					'integer' 		=> true,
					'description'	=>	__( 'Default value 4. Max value 10', 'siteorigin-widgets' ),
				),
			),
			//The $base_folder path string.
			get_template_directory()."/so-widgets/so-hero-video"
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
siteorigin_widget_register('so-hero-video', __FILE__, 'SP_HERO_VIDEO');
