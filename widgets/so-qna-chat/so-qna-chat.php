<?php
/*
	Widget Name: Sputznik Q&A Chat
	Description: Q&A Chat Widget.
	Author: Stephen Anil, Sputznik
	Author URI:	https://sputznik.com
	Widget URI:
	Video URI:
*/
class SP_QNA_CHAT extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'so-qna-chat',
			// The name of the widget for display purposes.
			__('Sputznik Q&A Chat', 'siteorigin-widgets'),
			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Sputznik Q&A Chat.'),
				'help'        => '',
			),
			//The $control_options array, which is passed through to WP_Widget
			array(),
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'user_one_image' => array(
					'type' 		=> 'media',
					'label' 	=> __( 'User One Image', 'siteorigin-widgets' ),
					'choose' 	=> __( 'Choose image', 'siteorigin-widgets' ),
					'update' 	=> __( 'Set image', 'siteorigin-widgets' ),
					'library' 	=> 'image',
					'fallback' 	=> false
				),
				'user_one_image_title' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'User One Image Title', 'siteorigin-widgets' ),
					'default' 	=> '',
				),
				'user_two_image' => array(
					'type' 		=> 'media',
					'label' 	=> __( 'User Two Image', 'siteorigin-widgets' ),
					'choose' 	=> __( 'Choose image', 'siteorigin-widgets' ),
					'update' 	=> __( 'Set image', 'siteorigin-widgets' ),
					'library' 	=> 'image',
					'fallback' 	=> false
				),
				'user_two_image_title' => array(
					'type' 			=> 'text',
					'label' 		=> __( 'User Two Image Title', 'siteorigin-widgets' ),
					'default' 	=> '',
				),
				'messages' => array(
					'type' 	=> 'repeater',
					'label' => __( 'Messages' , 'siteorigin-widgets' ),
					'item_name'  => __( 'Repeater item', 'siteorigin-widgets' ),
					'fields' => array(
						'user_one_msg' => array(
							'type' => 'tinymce',
							'label' => __( 'User One Message', 'siteorigin-widgets' ),
							'default' => '',
							'rows' => 10,
							'default_editor' => 'tinymce'
						),
						'user_two_msg' => array(
							'type' => 'tinymce',
							'label' => __( 'User Two Message', 'siteorigin-widgets' ),
							'default' => '',
							'rows' => 10,
							'default_editor' => 'tinymce'
						),

					)
				),

			),
			//The $base_folder path string.
			get_template_directory()."/so-widgets/so-qna-chat"
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
siteorigin_widget_register('so-qna-chat', __FILE__, 'SP_QNA_CHAT');
