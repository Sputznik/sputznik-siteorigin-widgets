<?php
/*
Widget Name: Sputznik Progress Bar
Description: An accessible, multi-layout progress bar widget.
Author: Stephen Anil, Sputznik
Author URI:	https://sputznik.com
*/

class SP_PROGRESS_BAR extends SiteOrigin_Widget {

	/**
	 * WIDGET FORM DEFAULTS
	 */
	protected static $sp_widget_form_defaults = array(
		'layout_type'            => 'layout-default',
		'current_value'          => 30,
		'max_value'              => 100,
		'value_prefix'           => '',
		'value_suffix'           => '%',
		'max_prefix'             => '',
		'max_suffix'             => '',
		'aria_template'          => 'Progress: ${value_prefix}${current_percentage}${value_suffix} out of ${max_prefix}${max_value}${max_suffix}.',
		'track_background_color' => '#e5e7eb',
		'track_foreground_color' => '#3b82f6',
	);

	function __construct(){
		$defaults = self::$sp_widget_form_defaults;

		parent::__construct(
			'so-progress-bar',
			__( 'Sputznik Progress Bar', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Display a dynamic customizable progress bar.', 'siteorigin-widgets' ),
				'help'        => '',
			),
			array(),
			array(
				'layout_type' => array(
					'type'    => 'select',
					'label'   => __( 'Widget Layout Style', 'siteorigin-widgets' ),
					'default' => $defaults['layout_type'],
					'options' => array(
						'layout-default' => __( 'Default Layout', 'siteorigin-widgets' ),
						// 'layout-two' => __( 'Layout Two', 'siteorigin-widgets' ),
					),
				),
				'settings_section' => array(
					'type'   => 'section',
					'label'  => __( 'Settings Section', 'siteorigin-widgets' ),
					'hide'   => false,
					'fields' => array(
						'current' => array(
							'type'   => 'section',
							'label'  => __( 'Current Value Options', 'siteorigin-widgets' ),
							'fields' => array(
								'value'  => array( 'type' => 'number', 'label' => __( 'Value', 'siteorigin-widgets' ), 'default' => $defaults['current_value'] ),
								'prefix' => array( 'type' => 'text', 'label' => __( 'Prefix', 'siteorigin-widgets' ), 'default' => $defaults['value_prefix'] ),
								'suffix' => array( 'type' => 'text', 'label' => __( 'Suffix', 'siteorigin-widgets' ), 'default' => $defaults['value_suffix'] ),
							)
						),
						'max' => array(
							'type'   => 'section',
							'label'  => __( 'Maximum Threshold Options', 'siteorigin-widgets' ),
							'fields' => array(
								'value'  => array( 'type' => 'number', 'label' => __( 'Value', 'siteorigin-widgets' ), 'default' => $defaults['max_value'] ),
								'prefix' => array( 'type' => 'text', 'label' => __( 'Prefix', 'siteorigin-widgets' ), 'default' => $defaults['max_prefix'] ),
								'suffix' => array( 'type' => 'text', 'label' => __( 'Suffix', 'siteorigin-widgets' ), 'default' => $defaults['max_suffix'] ),
							)
						),
						'aria_template' => array(
							'type'        => 'text',
							'label'       => __( 'Accessible Screen Reader Text Template', 'siteorigin-widgets' ),
							'default'     => $defaults['aria_template'],
							'description' => __( 'Available placeholders: ${current_value}, ${current_percentage}, ${max_value}, ${value_prefix}, ${value_suffix}, ${max_prefix}, ${max_suffix}', 'siteorigin-widgets' ),
						),
					),
				),
				'design_section' => array(
					'type'   => 'section',
					'label'  => __( 'Design Section', 'siteorigin-widgets' ),
					'hide'   => true,
					'fields' => array(
						'track' => array(
							'type'   => 'section',
							'label'  => __( 'Progress Track Style', 'siteorigin-widgets' ),
							'fields' => array(
								'background_color' => array( 'type' => 'color', 'label' => __( 'Background Color (Track)', 'siteorigin-widgets' ), 'default' => $defaults['track_background_color'] ),
								'foreground_color' => array( 'type' => 'color', 'label' => __( 'Foreground Color (Fill)', 'siteorigin-widgets' ), 'default' => $defaults['track_foreground_color'] ),
							)
						),
					),
				),
			),
			plugin_dir_path(__FILE__)
		);
	}

	/**
	 * FRONTEND MODEL
	 */
	public function get_layout_data( $instance ){
		$current_nodes = isset( $instance['settings_section']['current'] ) ? $instance['settings_section']['current'] : array();
		$max_nodes     = isset( $instance['settings_section']['max'] ) ? $instance['settings_section']['max'] : array();
		$track_nodes   = isset( $instance['design_section']['track'] ) ? $instance['design_section']['track'] : array();

		$user_configs = array(
			'layout_type'            => isset( $instance['layout_type'] ) ? $instance['layout_type'] : '',
			'current_value'          => isset( $current_nodes['value'] ) ? $current_nodes['value'] : null,
			'value_prefix'           => isset( $current_nodes['prefix'] ) ? $current_nodes['prefix'] : null,
			'value_suffix'           => isset( $current_nodes['suffix'] ) ? $current_nodes['suffix'] : null,
			'max_value'              => isset( $max_nodes['value'] ) ? $max_nodes['value'] : null,
			'max_prefix'             => isset( $max_nodes['prefix'] ) ? $max_nodes['prefix'] : null,
			'max_suffix'             => isset( $max_nodes['suffix'] ) ? $max_nodes['suffix'] : null,
			'aria_template'          => isset( $instance['settings_section']['aria_template'] ) ? $instance['settings_section']['aria_template'] : null,
			'track_background_color' => isset( $track_nodes['background_color'] ) ? $track_nodes['background_color'] : null,
			'track_foreground_color' => isset( $track_nodes['foreground_color'] ) ? $track_nodes['foreground_color'] : null,
		);

		// STRIP EMPTY PROPERTIES TO FALLBACK ONTO THE DEFAULTS
		$user_configs = array_filter( $user_configs, function( $val ){ return !is_null($val); } );
		$settings = wp_parse_args( $user_configs, self::$sp_widget_form_defaults );

		$current    = floatval( $settings['current_value'] );
		$max        = floatval( $settings['max_value'] );
		$val_prefix = esc_html( $settings['value_prefix'] );
		$val_suffix = esc_html( $settings['value_suffix'] );
		$max_prefix = esc_html( $settings['max_prefix'] );
		$max_suffix = esc_html( $settings['max_suffix'] );

		$percentage = ( $max > 0 ) ? max( 0, min( 100, ( $current / $max ) * 100 ) ) : 0;
		$rounded_percentage = round( $percentage );

		$tokens = array(
			'${current_value}'      => $current,
			'${current_percentage}' => $rounded_percentage,
			'${max_value}'          => $max,
			'${value_prefix}'       => $val_prefix,
			'${value_suffix}'       => $val_suffix,
			'${max_prefix}'         => $max_prefix,
			'${max_suffix}'         => $max_suffix,
		);

		$aria_value_text = str_replace( array_keys( $tokens ), array_values( $tokens ), sanitize_text_field( $settings['aria_template'] ) );

		return array(
			'track'   => array(
				'bg_color' => esc_attr( $settings['track_background_color'] ),
				'fg_color' => esc_attr( $settings['track_foreground_color'] ),
			),
			'current' => array(
				'value'      => $current,
				'percentage' => $rounded_percentage,
				'prefix'     => $val_prefix,
				'suffix'     => $val_suffix,
			),
			'max'     => array(
				'value'      => $max,
				'prefix'     => $max_prefix,
				'suffix'     => $max_suffix,
			),
			'aria_value_text' => $aria_value_text
		);
	}

	private function get_validated_layout( $instance ){
		$chosen_layout = ! empty( $instance['layout_type'] ) ? sanitize_file_name( $instance['layout_type'] ) : self::$sp_widget_form_defaults['layout_type'];
		$template_dir  = plugin_dir_path(__FILE__) . $this->get_template_dir($instance);
		$target_file   = trailingslashit( $template_dir ) . $chosen_layout . '.php';

		if( !file_exists( $target_file ) ){
			return self::$sp_widget_form_defaults['layout_type'];
		}

		return $chosen_layout;
	}

	function get_template_name( $instance ){
		return $this->get_validated_layout( $instance );
	}

	function get_template_dir( $instance ){
		return 'templates';
	}

	function get_style_name( $instance ){
		return '';
	}

	/**
	 * SANITIZE WIDGET FORM
	 */
	function modify_instance( $instance ){
		if( isset( $instance['settings_section']['current']['value'] ) ){
			$instance['settings_section']['current']['value'] = floatval( $instance['settings_section']['current']['value'] );
			if( $instance['settings_section']['current']['value'] < 0 ){
				$instance['settings_section']['current']['value'] = 0;
			}
		}

		if( isset( $instance['settings_section']['max']['value'] ) ){
			$instance['settings_section']['max']['value'] = floatval( $instance['settings_section']['max']['value'] );
			if( $instance['settings_section']['max']['value'] <= 0 ){
				$instance['settings_section']['max']['value'] = self::$sp_widget_form_defaults['max_value'];
			}
		}

		if( isset( $instance['settings_section']['aria_template'] ) ){
			$instance['settings_section']['aria_template'] = sanitize_text_field( $instance['settings_section']['aria_template'] );
		}

		if( isset( $instance['design_section']['track']['background_color'] ) ){
			$instance['design_section']['track']['background_color'] = sanitize_hex_color( $instance['design_section']['track']['background_color'] );
		}

		if( isset( $instance['design_section']['track']['foreground_color'] ) ){
			$instance['design_section']['track']['foreground_color'] = sanitize_hex_color( $instance['design_section']['track']['foreground_color'] );
		}

		return $instance;
	}

}

siteorigin_widget_register( 'so-progress-bar', __FILE__, 'SP_PROGRESS_BAR' );
