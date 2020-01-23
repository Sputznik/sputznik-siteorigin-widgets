<?php
/*
  Widget Name: Sputznik Multi-purpose Button
  Description: Multi-purpose button that can be floating in nature or open a modal box
  Author: Samuel Thomas, Sputznik
  Author URI: https://sputznik.com
  Widget URI:
*/

class SP_MULTI_BUTTON extends SiteOrigin_Widget{

  function __construct(){
    //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
    //Call the parent constructor with the required arguments.
    parent::__construct(
      // The unique id for your widget.
      'so-multi-button',
      // The name of the widget for display purposes.
      __( 'Multi-purpose Button', 'siteorigin-widgets' ),
      // The $widget_options array, which is passed through to WP_Widget.
      // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
      array(
        'description' => __( 'Multi-purpose Button that can be floating in nature and open a modal box', 'siteorigin-widgets' ),
        'help'        => '',
      ),
      //The $control_options array, which is passed through to WP_Widget
      array(),
      //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
      array(
        'btn_text' => array(
            'type'    => 'text',
            'label'   => __('Button Text','siteorigin-widget'),
            'default' => 'Button',
        ),
        'is_floating' => array(
					'type'     => 'checkbox',
					'label'    => __( 'Is Floating Button', 'siteorigin-widgets' ),
					'default'  => false,
					'state_emitter' => array(
						'callback' 	  => 'conditional',
						'args' 	=> array(
							'is_floating[active]: val',
							'is_floating[inactive]: !val'
						)
					),
				),
        'target_id'  =>  array(
          'type'    =>  'text',
          'label'   =>  'Enter the target ID',
          'default' =>  'sample',
          'state_handler' => array(
  					'is_floating[active]' 	=> array('show'),
  					'_else[is_floating]' 	=> array('hide'),
  				),
        ),
        'is_modal' => array(
					'type' => 'checkbox',
					'label' => __( 'Open Modal Box', 'siteorigin-widgets' ),
					'default' => false,
					'state_emitter' => array(
						'callback' 	=> 'conditional',
						'args' 		=> array(
							'is_modal[active]: val',
							'is_modal[inactive]: !val'
						)
					),
				),
        'modal_id'  =>  array(
          'type'    =>  'text',
          'label'   =>  'Enter the modal ID',
          'default' =>  '',
          'state_handler' => array(
  					'is_modal[active]' 	=> array('show'),
  					'_else[is_modal]' 	=> array('hide'),
  				),
        ),
        'modal_dialog_width' => array(
					'type' 	=> 'multi-measurement',
					'label' => __( 'Modal Dialog Width', 'siteorigin-widgets'),
          'autofill'  =>  true,
          'default' => '600px',
          'measurements' => array(
            'width' => array(
              'units' => array( 'px','%' ),
            ),
          ),
					'state_handler' => array(
						'is_modal[active]' 	=> array('show'),
						'_else[is_modal]' 	=> array('hide'),
					),
				),
				'modal_builder' => array(
					'type' 	=> 'builder',
					'label' => __( 'Modal Content', 'siteorigin-widgets'),
					'state_handler' => array(
						'is_modal[active]' 	=> array('show'),
						'_else[is_modal]' 	=> array('hide'),
					),
				),
        'link' => array(
            'type'    => 'link',
            'label'   => __('Type in your url','siteorigin-widget'),
            'default' => 'https://www.example.com',
            'state_handler' => array(
  						'is_modal[active]' 	=> array('hide'),
  						'_else[is_modal]' 	=> array('show'),
  					),
        ),
        'align' => array(
          'type'     => 'select',
          'label'    => __( 'Choose Alignment', 'siteorigin-widgets' ),
          'options'  => array(
            'left'    => 'Left',
            'center'  => 'Center',
            'right'   => 'Right'
          ),
          'state_handler' => array(
  					'is_floating[active]' 	=> array( 'hide' ),
  					'_else[is_floating]' 	=> array( 'show' ),
  				),
        ),
      ),
      plugin_dir_path(__FILE__).'/widgets/so-multi-button'
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

siteorigin_widget_register( 'so-multi-button', __FILE__, 'SP_MULTI_BUTTON' );
